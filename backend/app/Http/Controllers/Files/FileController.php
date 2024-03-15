<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static public function index($name)
    {
        $path = Storage::disk('public')->path("cheks/$name");
        return response()->file($path);
    }
}
