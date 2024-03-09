<?php

namespace App\Http\Controllers\Service_combo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service_combo\Service_comboStoreRequest;
use App\Http\Requests\Service_combo\Service_comboUpdateRequest;
use App\Http\Resources\Service_combo\Service_comboResource;
use App\Models\Service_combo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Service_comboController extends Controller
{
    public function store(Service_comboStoreRequest $request)
    {
        $data = $request->validated();

        $timeDiscount = Carbon::now();

        $combo = Service_combo::create([
           'title' =>  $data['title'],
           'old_price' =>  $data['old_price'],
           'discount' =>  $data['discount'],
           'time_discount' =>  $timeDiscount,
            'count_level' => $data['count_level']
        ]);

        foreach ($data['services'] as $service) {
            $item = json_decode($service, true);
            $serviceId = $item['id'];
            $count = $item['count'];
            // Привязываем сервис к комбо с заданным count
            $combo->services()->attach($serviceId, ['count' => $count]);
        }

        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->path();

            $combo->addMedia($imagePath)->toMediaCollection('images');
        }

        return response()->json(['mess' => 1, 'data' => $combo]);
    }

    public function index()
    {
        return Service_comboResource::collection(Service_combo::all())->resolve();
    }

    public function show(string $id)
    {
        $combo = Service_combo::find($id);
        return new Service_comboResource($combo);
    }

    public function destroy(string $id)
    {
        $service = Service_combo::find($id);
        $service->delete();
        return response()->json(['mess' => 1, 'data' => '']);
    }

    public function update(Service_comboUpdateRequest $request, int $id)
    {
        $data = $request->validated();

        $combo = Service_combo::findOrFail($id);
        // Прикрепляем новое изображение
        if ($request->hasFile('img')) {
            $combo->getFirstMedia('images')->delete();
            $imagePath = $request->file('img')->path();
            $combo->addMedia($imagePath)->toMediaCollection('images');
        }

        $timeDiscount = Carbon::now();

        $combo->update([
            'title' =>  $data['title'],
            'old_price' =>  $data['old_price'],
            'discount' =>  $data['discount'],
            'time_discount' =>  $timeDiscount,
            'count_level' => $data['count_level']
        ]);

        foreach ($data['services'] as $service) {
            $item = json_decode($service, true);
            $serviceId = $item['id'];
            $count = $item['count'];
            // Привязываем сервис к комбо с заданным count
            $servicesData[$serviceId] = ['count' => $count];

            $combo->services()->sync($servicesData);
        }

        return response()->json(['mess' => 1, 'data' => $combo]);
    }
}
