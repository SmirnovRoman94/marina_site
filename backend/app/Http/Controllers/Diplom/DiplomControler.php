<?php

namespace App\Http\Controllers\Diplom;

use App\Http\Controllers\Controller;
use App\Http\Requests\Diplom\DiplomStoreRequest;
use App\Http\Requests\Diplom\DiplomUpdateRequest;
use App\Http\Resources\Diplom\DiplomResource;
use App\Models\Diplom;
use Illuminate\Http\Request;

class DiplomControler extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return DiplomResource::collection(Diplom::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiplomStoreRequest $request)
    {
        $data = $request->validated();
        $diplom = Diplom::firstOrCreate([
            'title' => $data['title'],

        ]);

        // Прикрепляем изображение
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->path();
            $diplom->addMedia($imagePath)->toMediaCollection('images');
        }

        return response()->json(['mess' => 1, 'data' => $diplom]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $diplom = Diplom::find($id);
        return new DiplomResource($diplom);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Diplom::find($id);
        $service->delete();
        return response()->json(['mess' => 1, 'data' => '']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiplomUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $diplom = Diplom::findOrFail($id);
        // Прикрепляем новое изображение
        if ($request->hasFile('img')) {
            $diplom->getFirstMedia('images')->delete();
            $imagePath = $request->file('img')->path();
            $diplom->addMedia($imagePath)->toMediaCollection('images');
        }

        $diplom->update([
            'title' => $data['title']
        ]);

        return response()->json(['mess' => 1, 'data' => $diplom]);
    }
}
