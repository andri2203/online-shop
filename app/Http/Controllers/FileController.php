<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function showImage(string $path, string $image)
    {
        $imagePath = storage_path("app/public/{$path}/{$image}");

        if (!file_exists($imagePath)) {
            abort(404);
        }

        return response()->file($imagePath);
    }
}
