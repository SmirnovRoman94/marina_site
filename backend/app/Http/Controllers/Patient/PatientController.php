<?php

namespace App\Http\Controllers\Patient;

use App\Events\SendMailAdminEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientStoreRequest;
use App\Http\Resources\Patient\PatientResource;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Service_combo\Service_comboResource;
use App\Models\Patient;
use App\Models\PatientService;
use App\Models\Product;
use App\Models\Service;
use App\Models\Service_combo;
use App\Models\User;
use App\Telegram\Handler;
use DefStudio\Telegraph\Facades\Telegraph;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function store(PatientStoreRequest $request)
    {
        $data = $request->validated();

        $patient = Patient::firstOrCreate([
            'user_id' => $data['user_id'],
            'diagnosis' => $data['diagnosis'] ?? null,
            'comments' => $data['comments'] ?? null,
        ]);

        $itemsServices = [];
        //добавление продуктов
        if(isset($data['products'])){
            $array = json_decode($data['products'], true);
            $productsData = [];
            foreach ($array as $key => $productId) {
                $productsData[$productId['id']] = ['count' => $productId['count']];
            }

            $products = Product::whereIn('id',  array_keys($productsData))->get();
            $result = [];
            foreach ($products as $el){
                $el->oder_count = $productsData[$el->id]['count'];
                array_push($result, $el);
            }
            $itemsServices = array_merge($itemsServices, $result);
            foreach ($products as $product) {
                $count = $productsData[$product->id]['count'];
                $patientService = PatientService::where('patient_id', $patient->id)
                    ->where('item_id', $product->id)
                    ->where('item_type', 'Product')
                    ->first();
                if ($patientService) {
                    // Если запись найдена, увеличиваем count на 5
                    $patientService->count += $count;
                    $patientService->save();
                } else {
                    // Если запись не найдена, создаем новую запись
                    $values = [
                        'patient_id' => $patient->id,
                        'item_id' => $product->id,
                        'item_type' => 'Product',
                        'count' => $count // В данном случае начальное значение count равно 5
                    ];
                    PatientService::create($values);
                }
            }
        }

        //добавление сервисов
        if(isset($data['services'])){
            $array = json_decode($data['services'], true);
            $productsData = [];
            foreach ($array as $key => $productId) {
                $productsData[$productId['id']] = ['count' => $productId['count']];
            }
            $services = Service::whereIn('id',  array_keys($productsData))->get();
            $result = [];
            foreach ($services as $el){
                $el->oder_count = $productsData[$el->id]['count'];
                array_push($result, $el);
            }
            $itemsServices = array_merge($itemsServices, $result);
            foreach ($services as $service) {
                $count = $productsData[$service->id]['count'];
                $patientService = PatientService::where('patient_id', $patient->id)
                    ->where('item_id', $service->id)
                    ->where('item_type', 'Service')
                    ->first();
                if ($patientService) {
                    // Если запись найдена, увеличиваем count на 5
                    $patientService->count += $count;
                    $patientService->save();
                } else {
                    // Если запись не найдена, создаем новую запись
                    $values = [
                        'patient_id' => $patient->id,
                        'item_id' => $service->id,
                        'item_type' => 'Service',
                        'count' => $count // В данном случае начальное значение count равно 5
                    ];
                    PatientService::create($values);
                }
            }
        }

        //добавление комбо
        if(isset($data['service_combo'])){
            $array = json_decode($data['service_combo'], true);
            $productsData = [];
            foreach ($array as $key => $productId) {
                $productsData[$productId['id']] = ['count' => $productId['count']];
            }
            $service_combos = Service_combo::whereIn('id',  array_keys($productsData))->get();
            $resultCombos = [];
            foreach ($service_combos as $el){
                $el->price = $el->old_price-(($el->old_price*$el->discount)/100);
                $el->oder_count = $productsData[$el->id]['count'];
                array_push($resultCombos, $el);
            }
            $itemsServices = array_merge($itemsServices, $resultCombos);
            foreach ($service_combos as $service_combo) {
                $count = $productsData[$service_combo->id]['count'];
                $patientService = PatientService::where('patient_id', $patient->id)
                    ->where('item_id', $service_combo->id)
                    ->where('item_type', 'Service_combo')
                    ->first();
                if ($patientService) {
                    // Если запись найдена, увеличиваем count на 5
                    $patientService->count += $count;
                    $patientService->save();
                } else {
                    // Если запись не найдена, создаем новую запись
                    $values = [
                        'patient_id' => $patient->id,
                        'item_id' => $service_combo->id,
                        'item_type' => 'Service_combo',
                        'count' => $count // В данном случае начальное значение count равно 5
                    ];
                    PatientService::create($values);
                }
            }
        }

        $user = User::findOrFail($data['user_id']);
        if ($request->hasFile('file_check')) {
            $file = $request->file('file_check');
            $fileName = $request->file('file_check')->getClientOriginalName();
            $file->store('/public/checks');
            $name = $file->hashName();

            Event::dispatch(new SendMailAdminEvent($user ,$file, $itemsServices));
            Handler::sendNewOrder($name,$patient);
        }

        $patientItem = new PatientResource($patient);

        return response()->json(['mess' => 1, 'data' => $patientItem]);
    }

    public function index()
    {
        $patients = Patient::all();

        $patientItems = PatientResource::collection($patients);

        return response()->json(['mess' => 1, 'data' => $patientItems]);
    }

    public function patientUser(int $id)
    {
        $patient = Patient::where('user_id', $id)->first();

        $servicesIDs = $patient->services->pluck('item_id');
        $services = Service::whereIn('id', $servicesIDs)->get();
        $servicesRes = ServiceResource::collection($services);

        $combosIDs = $patient->serviceCombos->pluck('item_id');
        $combos = Service_combo::whereIn('id', $combosIDs)->get();
        $combosRes = Service_comboResource::collection($combos);

        $productsIDs = $patient->products->pluck('item_id');
        $products = Product::whereIn('id', $productsIDs)->get();
        $productsRes = ProductResource::collection($products);


        $result = $servicesRes->concat($combosRes)->concat($productsRes);

        return response()->json(['mess' => 1, 'data' => $result]);
    }
}
