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
        // dd($cart);
        $types = collect(ProductType::cases())->map(fn($type) => [
            'label' => ucfirst($type->name),
            'value' => $type->value,
        ]);

        $user = Auth::user();

        $products = Product::with(['productPrices' => function ($query) {
            $query->orderBy('created_at', 'desc'); // Atur urutan berdasarkan created_at
        }, 'latestProductPrice', 'productPhotoTypes', 'user']);

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
        $data['product_photo_types'] = $data['products']->pluck('productPhotoTypes')
            ->map(fn($data) => collect($data)->filter(fn($data) => $data['type'] != ""))->toArray();

        return view('welcome', $data);
    }

    public function tambah_keranjang(int $productID, ?int $productPhotoTypesID = null)
    {
        $store = session()->get('store');

        // Ambil produk dari database
        $product = Product::with(['latestProductPrice', 'productPhotoTypes', 'user' => ['paymentMethods']])->findOrFail($productID);

        if (!$product) {
            return redirect()->route('home')->with('danger', 'Barang yang dibeli tidak ditemukan');
        }

        // dd($store);
        if ($store != null && $store['id'] != $product->user->id) {
            return redirect()->route('home')->with('danger', 'Tidak bisa menambahkan produk berbeda Toko');
        }

        // Data yang akan disimpan ke session
        $cartItem = [
            'id' => $product->id,
            'product' => $product->toArray(),
            'productPhotoType' => null,
            'quantity' => 1,
            'price' => $product->toArray()['latest_product_price'],
        ];

        if ($productPhotoTypesID != null) {
            $productPhotoType = collect($product->productPhotoTypes()->get()->toArray())->where('id', $productPhotoTypesID)->first();
            $cartItem['productPhotoType'] = $productPhotoType;
            $cartItem['id'] = $cartItem['id'] . "-" . $productPhotoType['id'];
        }

        // Ambil keranjang dari session (atau buat array kosong)
        $carts = session()->get('cart', []);
        $store = $product->toArray()['user'];

        $ids = array_column($carts, 'id');
        $cartSelectedIndex = array_search($productPhotoTypesID === null ? $productID : $productID . "-" . $productPhotoTypesID, $ids);

        if (empty($carts) || $cartSelectedIndex === false) {
            $carts[] = $cartItem;
        } else {
            $cartSelected = $carts[$cartSelectedIndex];
            $cartSelected['quantity']++;
            $carts[$cartSelectedIndex] = $cartSelected;
        }

        // Simpan kembali ke session
        session()->put('cart', $carts);
        session()->put('store', $store);

        return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function hapus_dari_keranjang($cart_index)
    {
        $carts = session()->get('cart', []);

        if (isset($carts[$cart_index])) {
            unset($carts[$cart_index]);
            session()->put('cart', $carts);
            if (empty($carts)) {
                session()->forget('store');
            }
        }

        return redirect()->route('home')->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}
