<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    static public function index(Request $request)
    {
        $name = $request->input('name');
        $path = Storage::disk('public')->path("checks/$name");
        return response()->file($path);
    }
}
