<?php

namespace App\Repositories;

use App\Enums\ProductType;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Services\FileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepositories
{
    static public function productTypes()
    {
        // Contoh penggunaan "$types = self::productTypes();"
        return ProductType::cases();
    }

    static public function getAllProduct()
    {
        return Product::with('latestProductPrice')->get()->toArray();
    }

    static public function getAllProductWithAllPrices(string $orderBy = 'desc')
    {
        return Product::with(['productPrices' => function ($query) use ($orderBy) {
            $query->orderBy('created_at', $orderBy); // Atur urutan berdasarkan created_at
        }, 'latestProductPrice'])->get()->toArray();
    }

    static public function getProductById(int $productId)
    {
        return Product::with('productPrices')->where('id', $productId)->first()->toArray();
    }

    static public function getProductByIdWithAllPrices(int $productId, string $orderBy = 'desc')
    {
        return Product::with(['productPrices' => function ($query) use ($orderBy) {
            $query->orderBy('created_at', $orderBy); // Atur urutan berdasarkan created_at
        }, 'latestProductPrice'])->where('id', $productId)->first()->toArray();
    }

    static public function getProductByType(String $productType)
    {
        return Product::with('productPrices')->where('type', $productType)->get();
    }

    static public function insertProduct(array $product)
    {
        DB::beginTransaction();

        $photo = FileService::uploadProductImage($product['photo']);
        try {

            $productInput = Product::create([
                'name' => $product['name'],
                'photo' => $photo,
                'description' => $product['description'],
                'stocks' => $product['stocks'],
                'type' => $product['type'],
                'user_id' => Auth::id(),
            ]);

            ProductPrice::create([
                'product_id' => $productInput->id,
                'price' => $product['price'],
                'discount_number' => $product['discount_number'] ?? 0,
                'discount_percent' => $product['discount_percent'] ?? 0,
            ]);

            DB::commit();

            return redirect('/toko/produk')->with('success', 'Berhasil menambahkan produk');
        } catch (\Throwable $th) {
            FileService::delete($photo);
            DB::rollBack();

            return back()->withInput()->with('danger', $th->getMessage());
        }
    }

    static public function updateProduct(int $productId, array $productInput)
    {
        $product = Product::find($productId);

        if (!array_key_exists('photo', $productInput)) {
            $productInput['photo'] = $product['photo'];
        } else {
            FileService::delete($product['photo']);
            $photo = FileService::uploadProductImage($product['photo']);
            $productInput['photo'] = $photo;
        }

        try {
            $product->fill($productInput);

            if (!$product->isDirty()) {
                return back()->with('danger', 'Tidak ada data yang dirubah');
            }

            $product->save();

            return redirect('/toko/produk')->with('success', 'Berhasil mengubah data produk');
        } catch (\Throwable $th) {
            return back()->withInput()->with('danger', $th->getMessage());
        }
    }

    static public function insertProductPrice(array $productPriceInput)
    {
        try {
            ProductPrice::create($productPriceInput);

            return redirect()->route('store.tambah.harga.produk', ['productID' => $productPriceInput['product_id']]);
        } catch (\Throwable $th) {
            return back()->withInput()->with('danger', $th->getMessage());
        }
    }

    static private function usedProductPrice(int $productPriceID)
    {
        $productPrice = ProductPrice::findOrFail($productPriceID);
        return $productPrice->orderDetails()->exists();
    }

    static private function onlyOneProductPrice(int $productPriceID)
    {
        $productPrice = ProductPrice::findOrFail($productPriceID);

        return $productPrice->count() == 1 ? true : false;
    }

    static public function updateProductPrice(int $productPriceId, array $productPriceInput)
    {
        if (self::usedProductPrice($productPriceId)) {
            return back()->with('danger', 'Harga tidak bisa diubah karena telah digunakan.');
        }
        try {
            $productPrice = ProductPrice::find($productPriceId);

            if (!$productPrice) {
                return back()->with('danger', 'Data harga produk tidak ditemukan.');
            }

            $productPrice->fill($productPriceInput);


            if ($productPrice->isDirty() == false) {
                return back()->with('danger', 'Kamu Tidak melakukan perubahan apapun');
            }

            $productPrice->save();

            return redirect()->route('store.tambah.harga.produk', ['productID' => $productPrice->product_id])->with('success', 'Berhasil Merubah Data');
        } catch (\Throwable $th) {
            return back()->withInput()->with('danger', $th->getMessage());
        }
    }

    static public function deleteProductPrice(int $productPriceId)
    {

        if (self::onlyOneProductPrice($productPriceId)) {
            return back()->with('danger', 'Tidak bisa hapus harga jika kurang dari 1 harga.');
        }

        if (self::usedProductPrice($productPriceId)) {
            return back()->with('danger', 'Tidak bisa hapus harga. Harga telah digunakan.');
        }

        try {
            $productPrice = ProductPrice::find($productPriceId);
            if (!$productPrice) {
                return back()->with('danger', 'Data harga produk tidak ditemukan.');
            }
            $productPrice->delete();

            return redirect()->route('store.tambah.harga.produk', ['productID' => $productPrice->product_id])->with('success', 'Berhasil Menghapus Data');
        } catch (\Throwable $th) {
            return back()->withInput()->with('danger', $th->getMessage());
        }
    }
}
