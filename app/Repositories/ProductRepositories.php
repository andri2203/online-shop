<?php

namespace App\Repositories;

use App\Enums\ProductType;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductPhotoType;
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
        }, 'latestProductPrice', 'productPhotoTypes'])->get()->toArray();
    }

    static public function getProductById(int $productId)
    {
        return Product::with(['productPrices', 'productPhotoTypes'])->where('id', $productId)->first()->toArray();
    }

    static public function getProductByIdWithAllPrices(int $productId, string $orderBy = 'desc')
    {
        return Product::with(['productPrices' => function ($query) use ($orderBy) {
            $query->orderBy('created_at', $orderBy); // Atur urutan berdasarkan created_at
        }, 'latestProductPrice', 'productPhotoTypes'])->where('id', $productId)->first()->toArray();
    }

    static public function getProductByType(String $productType)
    {
        return Product::with(['productPrices', 'productPhotoTypes'])->where('type', $productType)->get();
    }

    static public function insertProduct(array $product)
    {
        DB::beginTransaction();

        $photos = FileService::uploadBatchProductImage($product['photo']);
        $productPhotoTypes = collect();

        try {

            $productInput = Product::create([
                'name' => $product['name'],
                'photo' => $photos[0],
                'description' => $product['description'],
                'stocks' => $product['stocks'],
                'type' => $product['type'],
                'user_id' => Auth::id(),
            ]);

            for ($i = 0; $i < count($photos); $i++) {
                $photo = $photos[$i];
                $productPhotoType = $product['jenis_produk'][$i] ?? "";
                $arr = [
                    'product_id' => $productInput->id,
                    'photo' => $photo,
                    'type' => $productPhotoType,
                    "created_at" => now(),
                    "updated_at" => now()
                ];
                $productPhotoTypes->add($arr);
            }

            DB::table('product_photo_types')->insert($productPhotoTypes->toArray());

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
        DB::beginTransaction();
        $product = Product::find($productId);
        // Ambil data lama dari DB: [ ['id' => 1, 'photo' => 'lama.jpg'], ... ]
        $productPhotoTypesFromDatabase = ProductPhotoType::where('product_id', $productId)
            ->get(['id', 'photo'])
            ->keyBy('id');

        // Ubah input menjadi collection
        $productPhotoTypes = collect($productInput['product_photo_type']);

        // Cek setiap item dalam input, tambahkan photo dari DB jika belum ada
        $productPhotoTypes = $productPhotoTypes->map(function ($item) use ($productPhotoTypesFromDatabase) {
            if (empty($item['photo']) && isset($item['id'])) {
                $existing = $productPhotoTypesFromDatabase->get($item['id']);
                if ($existing && $existing->photo) {
                    $item['photo'] = $existing->photo;
                }
            }
            return $item;
        });

        $cleanedData = $productPhotoTypes->map(function ($item) {
            return array_merge($item, [
                'created_at' => $item['created_at'] ?? now(),
                'updated_at' => now(),
            ]);
        });


        try {
            $productUpdate = [
                'name' => $productInput['name'],
                'photo' => $productInput['first_photo'] ?? $product->photo, // fallback
                'description' => $productInput['description'],
                'stocks' => $productInput['stocks'],
                'type' => $productInput['type'],
            ];

            $product->fill($productUpdate);

            // Lakukan upsert
            ProductPhotoType::upsert(
                $cleanedData->toArray(),
                ['id'], // kolom unik
                ['type', 'photo', 'created_at', 'updated_at'] // kolom yang akan diupdate
            );

            if ($product->isDirty()) {
                $product->save();
            }

            DB::commit();
            return redirect('/toko/produk')->with('success', 'Berhasil mengubah data produk');
        } catch (\Throwable $th) {
            // Hapus file hanya jika benar-benar sudah diunggah
            $imagePaths = collect($productPhotoTypes)
                ->pluck('photo')
                ->filter() // hapus null
                ->unique()
                ->toArray();

            FileService::delete($imagePaths);

            DB::rollBack();
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
