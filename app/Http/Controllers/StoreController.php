<?php

namespace App\Http\Controllers;

use App\Enums\ProductType;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductPhotoType;
use App\Models\ProductPrice;
use App\Repositories\PaymentMethodRepositories;
use App\Repositories\ProductRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StoreController extends Controller
{
    public function __construct()
    {
        PaymentMethodRepositories::setup();
    }

    static protected  function userActive()
    {
        return auth()->guard()->user();
    }

    static protected function orders()
    {
        return  Order::whereHas('orderDetails.product', function ($query) {
            $query->where('user_id', self::userActive()->id);
        })
            ->with([
                'orderDetails.productPhotoType',
                'orderDetails.product.latestProductPrice',
                'user',
                'paymentMethod'
            ])
            ->latest()
            ->get();
    }

    public function beranda()
    {
        $orders = self::orders();

        $data = [
            'product_count' => self::userActive()->products->count(),
            'orders' => $orders->toArray(),
            'order_count' => $orders->count(),
            'totalSales' => $orders->sum('payment_total'),
        ];

        return view('toko.beranda', $data);
    }

    public function tambahProduk()
    {
        $data = [
            'tipe_produk' => ProductType::cases(),
        ];

        return view('toko.tambah-produk', $data);
    }

    public function dataProduk()
    {
        $products = ProductRepositories::getAllProduct();
        return view('toko.list-produk', [
            'products' => $products,
        ]);
    }

    public function editProduk(int $productID)
    {
        $product = ProductRepositories::getProductById($productID);

        if (empty($product['product_photo_types'])) {
            ProductPhotoType::create([
                'type' => '',
                'photo' => $product['photo'],
                'product_id' => $productID,
            ]);

            return redirect()->route('store.edit.produk', ['productID' => $productID]);
        }

        $data = [
            'tipe_produk' => ProductType::cases(),
            'produk' => $product,
        ];

        return view('toko.edit-produk', $data);
    }

    public function ubahHargaProduk(int $productID, ?int $productPriceID = null)
    {
        $product = ProductRepositories::getProductByIdWithAllPrices($productID);

        $data = [
            'tipe_produk' => ProductType::cases(),
            'produk' => $product,
            'productPrice' => null,
            'action' => 'store.tambah_harga_produk',
            'parameters' => ['productID' => $productID]
        ];

        if ($productPriceID !== null) {
            $data['action'] = 'store.ubah_harga_produk';
            $data['parameters'] = ['productPriceID' => $productPriceID];
            $data['productPrice'] = ProductPrice::find($productPriceID)->toArray();
        }

        return view('toko.tambah-harga-produk', $data);
    }

    public function pemesanan()
    {
        $orders = self::orders();
        // dd($orders->toArray());
        $data = [
            'orders' => $orders->toArray(),
        ];

        return view('toko.pemesanan', $data);
    }

    public function proses_pesanan(int $orderID, string $action)
    {
        DB::beginTransaction();

        $order = Order::findOrFail($orderID);

        if (!$order) {
            return back()->with('danger', 'Orderan tidak ditemukan');
        }

        try {
            $order->update(['status' => $action]);

            if ($action == "diproses") {
                $orderDetails = $order->orderDetails->all();
                $newProductStocks = collect();

                foreach ($orderDetails as $detail) {
                    $qty = $detail->qty;

                    $newProductStocks->push([
                        'id' => $detail->product->id,
                        'stocks' => $detail->product->stocks - $qty,
                    ]);
                }

                $ids = $newProductStocks->pluck('id')->all();
                $cases = '';
                foreach ($newProductStocks as $item) {
                    $cases .= "WHEN {$item['id']} THEN {$item['stocks']} ";
                }

                $sql = "UPDATE products SET stocks = CASE id {$cases} END WHERE id IN (" . implode(',', $ids) . ")";
                DB::statement($sql);
            }

            DB::commit();

            return redirect()->route('store.pesanan')->with('success', 'Update Berhasil. Produk sekarang berstatus ' . $action);
        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('danger', $th->getMessage());
        }
    }

    public function metodePembayaran(?int $paymentMethodID = null)
    {
        $data = [
            'payments' => PaymentMethodRepositories::getAllPaymentMethod(),
            'payment' => null,
            'action' => 'store.tambah_metode_pembayaran',
            'parameters' => []
        ];

        if ($paymentMethodID != null) {
            $data['payment'] = PaymentMethodRepositories::getPaymentMethodByID($paymentMethodID);
            $data['action'] = 'store.ubah_metode_pembayaran';
            $data['parameters'] = ['paymentMethodID' => $paymentMethodID];
        }

        return view('toko.metode-pembayaran', $data);
    }

    public function laporan()
    {
        return view('toko.laporan');
    }

    public function buatLaporan(Request $request)
    {
        $credentials = $request->validate([
            'report' => 'required',
        ]);

        $data = [];

        if ($credentials['report'] == 'LSP') { // Laporan Stock Product
            $data['title'] = 'Laporan Stok Produk';
            $data['header'] = ['Nama Produk', 'Stok', 'Tipe'];
            $data['body'] = Product::select('name', 'stocks', 'type')->get()->toArray();
        } else { // Laporan Penjualan
            $data['title'] = 'Laporan Penjualan';
            $data['header'] = ['Nama Produk', 'Jumlah Penjualan', 'Total Penjualan'];
            $data['body'] = Product::with(['orderDetails', 'latestProductPrice'])
                ->get()
                ->map(function ($product) {
                    // Hitung total qty dari semua orderDetails
                    $totalQty = $product->orderDetails->sum('qty');

                    // Ambil harga dari relasi latestProductPrice
                    $price = $product->latestProductPrice->price ?? 0;

                    // Hitung total penjualan
                    $totalSales = $price * $totalQty;

                    return [
                        'name' => $product->name,
                        'total_qty' => $totalQty,
                        'total_sales' => $totalSales,
                    ];
                })
                ->toArray();
        }

        return view('toko.report', $data);
    }

    public function downloadLaporan() {}

    // Create, Update & Delete Section
    public function tambah_produk(Request $request)
    {

        $credentials = $request->validate([
            'name' => 'required',
            'photo' => 'required|array',
            'photo.*' => 'required|image',
            'description' => 'required',
            'stocks' => 'required|integer',
            'type' => 'required',
            'price' => 'required|integer',
            'discount_number' => 'nullable|integer',
            'discount_percent' => 'nullable|integer',
            'jenis_produk' => 'array',
        ]);

        return ProductRepositories::insertProduct($credentials);
    }

    public function ubah_produk(Request $request, int $productID)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'stocks' => 'required|integer',
            'type' => 'required',

            'photo' => 'nullable|array',
            'photo.*' => 'nullable|image',
            'jenis_produk' => 'nullable|array',

            'edit_id' => 'nullable|array',
            'photo_edit' => 'nullable|array',
            'photo_edit.*' => 'nullable|image',
            'jenis_produk_edit' => 'nullable|array',
        ]);

        $data = [];

        // Untuk update
        foreach ($request->input('edit_id', []) as $i => $id) {
            if ($id == null) {
                continue;
            }
            $row = [
                'id' => $id,
                'type' => $request->jenis_produk_edit[$i] ?? null,
            ];

            $photoFile = $request->file('photo_edit')[$i] ?? null;
            if ($photoFile) {
                $photoPath = $photoFile->store('product', 'public');
                $row['photo'] = $photoPath;
            }

            $row['product_id'] = $productID; // opsional, untuk konsistensi
            $data[] = $row;
        }

        // Untuk insert baru
        if (isset($credentials['photo'])) {
            foreach ($credentials['photo'] as $j => $photo) {

                $photoPath = $photo->store('product', 'public');
                $type = $credentials['jenis_produk'][$j] ?? "";

                $data[] = [
                    'id' => null,
                    'type' => $type,
                    'photo' => $photoPath,
                    'product_id' => $productID,
                ];
            }
        }

        // Ambil satu photo pertama untuk update ke produk utama
        $firstPhoto = collect($data)->firstWhere('photo');

        $credentials['product_photo_type'] = $data;
        $credentials['first_photo'] = $firstPhoto['photo'] ?? null;

        return ProductRepositories::updateProduct($productID, $credentials);
    }


    public function tambah_harga_produk(Request $request, int $productID)
    {
        $credentials = $request->validate([
            'price' => 'required|integer',
            'discount_number' => 'nullable|integer',
            'discount_percent' => 'nullable|integer',
        ]);

        $credentials['product_id'] = $productID;

        return ProductRepositories::insertProductPrice($credentials);
    }

    public function ubah_harga_produk(Request $request, int $productPriceID)
    {
        $credentials = $request->validate([
            'price' => 'required|integer',
            'discount_number' => 'nullable|integer',
            'discount_percent' => 'nullable|integer',
        ]);

        return ProductRepositories::updateProductPrice($productPriceID, $credentials);
    }

    public function hapus_harga_produk(int $productPriceID)
    {
        return ProductRepositories::deleteProductPrice($productPriceID);
    }

    public function tambah_metode_pembayaran(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'account_number' => 'required',
        ]);

        return PaymentMethodRepositories::createPaymentMethod($credentials);
    }

    public function ubah_metode_pembayaran(Request $request, int $paymentMethodID)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'account_number' => 'required',
        ]);

        return PaymentMethodRepositories::updatePaymentMethod($paymentMethodID, $credentials);
    }

    public function hapus_metode_pembayaran(int $paymentMethodID)
    {
        return PaymentMethodRepositories::deletePaymentMethod($paymentMethodID);
    }
}
