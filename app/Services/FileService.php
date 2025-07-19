<?php

namespace App\Services;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

class FileService
{

    static protected string $product = 'product';

    static protected string $user = 'user';

    static protected string $payment = 'payment';

    static protected function doUpload($path, $image)
    {
        return Storage::disk('public')->putFile($path, $image);
    }

    static protected function doShow(string $path, string $image)
    {
        $path = "app/public/" . $path . "/" . $image;

        $image = storage_path($path);

        return response()->file($image);
    }

    static public function delete(string|array $imagePath)
    {
        return Storage::delete($imagePath);
    }

    static public function uploadProductImage($image)
    {
        return self::doUpload(self::$product, $image);
    }

    static public function uploadBatchProductImage(array $images)
    {
        $filenames = collect();

        foreach ($images as $image) {
            $file = self::doUpload(self::$product, $image);
            $filenames->add($file);
        }

        return $filenames->toArray();
    }

    static public function uploadAvatar($image)
    {
        return self::doUpload(self::$user, $image);
    }

    static public function uploadPayment($image)
    {
        return self::doUpload(self::$payment, $image);
    }

    static public function showImageProduct(string $image)
    {
        return self::doShow(self::$product, $image);
    }

    static public function showUserImage(string $image)
    {
        return self::doShow(self::$user, $image);
    }

    static public function showPaymentImage(string $image)
    {
        return self::doShow(self::$payment, $image);
    }
}
