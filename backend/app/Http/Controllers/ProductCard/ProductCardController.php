<?php

namespace App\Http\Controllers\ProductCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCard;

class ProductCardController extends Controller
{
    public function store(Request $request)
    {

        // Создайте новую карточку товара
        $card = new ProductCard();
        $card->title = $request->input('title');
        $card->description = $request->input('description');
        $card->save();

        // Загружаем изображение и привязываем его к карточке товара
        $card->addMediaFromRequest('img')->toMediaCollection('images');

        return response()->json(['mess' => 1, 'data' => $card]);
    }

    public function show($id)
    {
        $card = ProductCard::findOrFail($id);

        // Получаем данные карточки товара
        $title = $card->title;
        $description = $card->description;
        $image = $card->getFirstMedia('images')->getFullUrl(); // Получаем URL-адрес изображения

        // Возвращаем данные карточки товара в качестве ответа
        return response()->json([
            'title' => $title,
            'description' => $description,
            'image' => $image
        ]);
    }
}
