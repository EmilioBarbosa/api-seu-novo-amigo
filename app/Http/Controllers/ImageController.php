<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Recebe como parametro o nome do arquivo
     * Sem o caminho
     */
    public function getAnimalImage($path)
    {
        $image = Storage::get("/images/animals/{$path}");
        $mymeType = Storage::mimeType("/images/animals/{$path}");

        return response($image, 200)->header('Content-Type', $mymeType);
    }
}
