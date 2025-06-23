<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    static protected  function userActive()
    {
        return auth()->guard()->user();
    }

    public function pembayaran()
    {
        $cart = session()->get('cart', []);
        $store = session()->get('store');

        if (count($cart) == 0) {
            return back()->with('danger', 'Tidak Produk yang di pesan');
        }

        $data = [
            'carts' => $cart,
            'store' => $store,
            'bayar_langsung' => session()->get('bayar_langsung') ?? false
        ];

        return view('pembayaran', $data);
    }

    public function semua_orderan()
    {
        $order = self::userActive()->orders;
        $cart = session()->get('cart', []);

        $data = [
            'cart' => $cart,
            'user' => self::userActive(),
            'orders' => $order,
        ];

        return view('order', $data);
    }

    public function orderan_anda(int $orderID)
    {
        $cart = session()->get('cart', []);
        $order = self::userActive()->orders->findOrFail($orderID);
        $orderDetails = OrderDetail::with(['product', 'productPrice'])->where('order_id', $order->id)->get();
        $paymentMethod = $order->paymentMethod->toArray();

        if (!$order) {
            return redirect()->route('home')->with('danger', 'Data Order tidak ditemukan');
        }

        $data = [
            'order' => $order->toArray(),
            'order_details' => $orderDetails->toArray(),
            'payment_method' => $paymentMethod,
            'isCOD' => $paymentMethod['name'] == "COD",
            'cart' => $cart,
            'user' => self::userActive(),
        ];

        return view('orderan-anda', $data);
    }

    public function hapus_beli_langsung()
    {
        session()->forget('cart');
        session()->put('bayar_langsung', false);
        return redirect()->route('home');
    }

    public function proses_beli_langsung(int $productID)
    {
        $store = session()->get('store');

        // Ambil produk dari database
        $product = Product::with(['latestProductPrice', 'user' => ['paymentMethods']])->findOrFail($productID);

        if (!$product) {
            return redirect()->route('home')->with('danger', 'Barang yang dibeli tidak ditemukan');
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
        $cart[$productID] = $cartItem; // tambahkan item baru
        $store = $product->toArray()['user'];

        // Simpan kembali ke session
        session()->put('cart', $cart);
        session()->put('store', $store);
        session()->put('bayar_langsung', true);

        return redirect()->route('bayar.proses');
    }

    public function proses_pembayaran(Request $request)
    {
        $credential = $request->validate([
            'payment_method_id' => 'required',
            'address' => 'required',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        DB::beginTransaction();

        try {
            $payment_total = 0;
            foreach ($credential['qty'] as $productId => $qty) {
                $total = $cart[$productId]['price']['price'] * $qty;
                $payment_total += $total;
            }

            $order = Order::create([
                'address' => $credential['address'],
                'user_id' => self::userActive()->id,
                'payment_method_id' =>  $credential['payment_method_id'],
                'payment_total' => $payment_total,
                'status' => 'menunggu',
            ]);

            $orderDetails = [];
            foreach ($credential['qty'] as $productId => $qty) {
                $orderDetails[] = [
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_price_id' => $cart[$productId]['price']['id'],
                    'qty' => $qty,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            OrderDetail::insert($orderDetails);

            DB::commit();
            session()->forget('store');
            session()->forget('cart');
            session()->put('bayar_langsung', false);

            return redirect()->route('orderan_anda', ['orderID' => $order->id]);
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('danger', $th->getMessage());
        }
    }

    public function proses_upload_bukti_bayar(Request $request, int $orderID)
    {
        $credential = $request->validate([
            'payment_photo' => 'required|image'
        ]);

        $order = Order::findOrFail($orderID);

        if (!$order) {
            return back()->with('danger', 'Data Order tidak ditemukan');
        }

        $photo = FileService::uploadPayment($credential['payment_photo']);

        try {
            $order->update([
                'payment_photo' => $photo
            ]);

            return redirect()->route('semua_orderan')->with('success', 'Berhasil melakukan pembayaran');
        } catch (\Throwable $th) {
            FileService::delete($photo);
            return back()->withInput()->with('danger', $th->getMessage());
        }
    }
}
