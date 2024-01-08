<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Resources\Service\ServiceResource;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ServiceResource::collection(Service::all())->resolve();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {
        $data = $request->validated();
        $service = Service::firstOrCreate([
            'description' => $data['description'],
            'price' => $data['price'],
            'title' => $data['title'],
            'form' => $data['form'],
            'duration' => $data['duration'],
            'preview' => $data['preview']
        ]);

        // Прикрепляем изображение
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->path();
            $service->addMedia($imagePath)->toMediaCollection('images');
        }

        return response()->json(['mess' => 1, 'data' => $service]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::find($id);
        return new ServiceResource($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        $service->delete();
        return response()->json(['mess' => 1, 'data' => '']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        $service = Service::findOrFail($id);
        // Прикрепляем новое изображение
        if ($request->hasFile('img')) {
            $service->getFirstMedia('images')->delete();
            $imagePath = $request->file('img')->path();
            $service->addMedia($imagePath)->toMediaCollection('images');
        }

        $service->update([
            'description' => $data['description'],
            'price' => $data['price'],
            'title' => $data['title'],
            'form' => $data['form'],
            'duration' => $data['duration'],
            'preview' => $data['preview']
        ]);

        return response()->json(['mess' => 1, 'data' => $service]);
    }
}
