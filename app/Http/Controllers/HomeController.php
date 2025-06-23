<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(?string $type = null)
    {
        $cart = session()->get('cart', []);

        $types = collect(ProductType::cases())->map(fn($type) => [
            'label' => ucfirst($type->name),
            'value' => $type->value,
        ]);

        $user = Auth::user();

        $products = Product::with(['productPrices' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Atur urutan berdasarkan created_at
        }, 'latestProductPrice', 'user']);

        $data = [
            'cart' => $cart,
            'user' => $user,
            'types' => $types,
            'type' => $type,
            'grid_cols' => 'grid-cols-' . $types->count(),
        ];

        if ($type != null) {
            $products = $products->where('type', $type);
        }
        $data['products'] = $products->get();

        return view('welcome', $data);
    }

    public function tambah_keranjang(int $productID)
    {
        $store = session()->get('store');

        // Ambil produk dari database
        $product = Product::with(['latestProductPrice', 'user'])->findOrFail($productID);

        if (!$product) {
            return redirect()->route('home')->with('danger', 'Barang yang dibeli tidak ditemukan');
        }

        if ($store != null && $store['id'] != $product->id) {
            return redirect()->route('home')->with('danger', 'Tidak bisa menambahkan produk berbeda Toko');
        }

        // Data yang akan disimpan ke session
        $cartItem = [
            'id' => $product->id,
            'product' => $product->toArray(),
            'quantity' => 1,
            'price' => $product->toArray()['latest_product_price'],
        ];

        // Ambil keranjang dari session (atau buat array kosong)
        $cart = session()->get('cart', []);

        // Cek apakah produk sudah ada di keranjang
        if (isset($cart[$productID])) {
            $cart[$productID]['quantity']++; // tambahkan jumlah
        } else {
            $cart[$productID] = $cartItem; // tambahkan item baru
        }

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function hapus_dari_keranjang($productID)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productID])) {
            unset($cart[$productID]);
            session()->put('cart', $cart);
        }

        return response()->json(['message' => 'Produk dihapus']);
    }
}
