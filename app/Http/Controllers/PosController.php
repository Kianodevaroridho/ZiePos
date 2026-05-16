<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->where('stock', '>', 0);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->with('category')->get();
        $categories = \App\Models\Category::all();
        $cart = session()->get('cart', []);

        return view('pos.index', compact('products', 'categories', 'cart'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] + 1 > $product->stock) {
                return redirect()->route('pos.index')
                    ->with('error', 'Stok tidak mencukupi!');
            }
            $cart[$product->id]['quantity']++;
            $cart[$product->id]['subtotal'] = $cart[$product->id]['quantity'] * $cart[$product->id]['price'];
        } else {
            if ($product->stock < 1) {
                return redirect()->route('pos.index')
                    ->with('error', 'Stok habis!');
            }
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('pos.index')
            ->with('success', $product->name . ' ditambahkan ke keranjang!');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $product = Product::findOrFail($request->product_id);

        if (isset($cart[$request->product_id])) {
            if ($request->quantity > $product->stock) {
                return redirect()->route('pos.index')
                    ->with('error', 'Stok tidak mencukupi! Stok tersedia: ' . $product->stock);
            }
            $cart[$request->product_id]['quantity'] = $request->quantity;
            $cart[$request->product_id]['subtotal'] = $request->quantity * $cart[$request->product_id]['price'];
            session()->put('cart', $cart);
        }

        return redirect()->route('pos.index');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('pos.index')
            ->with('success', 'Item dihapus dari keranjang!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('pos.index')
            ->with('success', 'Keranjang dikosongkan!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('pos.index')
                ->with('error', 'Keranjang kosong!');
        }

        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer',
        ]);

        $totalAmount = collect($cart)->sum('subtotal');

        if ($request->paid_amount < $totalAmount) {
            return redirect()->route('pos.index')
                ->with('error', 'Jumlah pembayaran kurang!');
        }

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $totalAmount,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($cart as $productId => $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi stok
                $product = Product::find($productId);
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil! Invoice: ' . $transaction->invoice_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pos.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
