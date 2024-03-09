<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(ProductStoreRequest $request)
    {
        $data = $request->validated();

        $product = Product::firstOrCreate([
            'description' => $data['description'],
            'price' => $data['price'],
            'title' => $data['title'],
        ]);

        // Прикрепляем изображение
        if ($request->hasFile('media')) {
            $imagePath = $request->file('media')->path();
            $product->addMedia($imagePath)->toMediaCollection('media');
        }

        return response()->json(['mess' => 1, 'data' => $product]);
    }

    public function index()
    {
        return ProductResource::collection(Product::all())->resolve();
    }

    public function show(string $id)
    {
        $product = Product::find($id);
        return new ProductResource($product);
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(['mess' => 1, 'data' => '']);

    }

    public function update(ProductUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $product = Product::findOrFail($id);

        // Прикрепляем новый файл
        if ($request->hasFile('media')) {
            $product->getFirstMedia('media')->delete();
            $imagePath = $request->file('media')->path();
            $product->addMedia($imagePath)->toMediaCollection('media');
        }

        $product->update([
            'description' => $data['description'],
            'price' => $data['price'],
            'title' => $data['title'],
        ]);

        return response()->json(['mess' => 1, 'data' => $product]);
    }
}
