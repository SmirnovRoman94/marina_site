<?php

namespace App\Http\Controllers\Patient;

use App\Events\SendMailAdminEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientStoreRequest;
use App\Http\Resources\Patient\PatientResource;
use App\Models\Patient;
use App\Models\PatientService;
use App\Models\Product;
use App\Models\Service;
use App\Models\Service_combo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

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
            $productsData = [];
            $regex = '/{id: (\d+), count: (\d+)}/';
            preg_match_all($regex, $data['products'][0], $matches);
            foreach ($matches[1] as $key => $productId) {
                $productsData[$productId] = ['count' => $matches[2][$key]];
            }

            $products = Product::whereIn('id',  array_keys($productsData))->get();
            $itemsServices = array_merge($itemsServices, $products);
            foreach ($products as $product) {
                $count = $productsData[$product->id]['count'];
                $condition = [
                    'patient_id' => $patient->id,
                    'item_id' => $product->id,
                    'item_type' => 'Product'
                ];
                $values = [
                    'patient_id' => $patient->id,
                    'item_id' => $product->id,
                    'item_type' => 'Product',
                    'count' => $count
                ];
                PatientService::updateOrCreate($condition, $values);
            }
        }

        //добавление сервисов
        if(isset($data['services'])){
            $productsData = [];
            $regex = '/{id: (\d+), count: (\d+)}/';
            preg_match_all($regex, $data['services'][0], $matches);
            foreach ($matches[1] as $key => $productId) {
                $productsData[$productId] = ['count' => $matches[2][$key]];
            }

            $services = Service::whereIn('id',  array_keys($productsData))->get();
            $itemsServices = array_merge($itemsServices, $services);
            foreach ($services as $service) {
                $count = $productsData[$service->id]['count'];
                $condition = [
                    'patient_id' => $patient->id,
                    'item_id' => $service->id,
                    'item_type' => 'Service'
                ];
                $values = [
                    'patient_id' => $patient->id,
                    'item_id' => $service->id,
                    'item_type' => 'Service',
                    'count' => $count
                ];
                PatientService::updateOrCreate($condition, $values);
            }
        }

        //добавление комбо
        if(isset($data['service_combo'])){
            $productsData = [];
            $regex = '/{id: (\d+), count: (\d+)}/';
            preg_match_all($regex, $data['service_combo'][0], $matches);
            foreach ($matches[1] as $key => $productId) {
                $productsData[$productId] = ['count' => $matches[2][$key]];
            }

            $service_combos = Service_combo::whereIn('id',  array_keys($productsData))->get();
            $resultCombos = [];
            foreach ($service_combos as $el){
                $el->price = $el->old_price-(($el->old_price*$el->discount)/100);;
                array_push($resultCombos, $el);
            }
            $itemsServices = array_merge($itemsServices, $resultCombos);
            foreach ($service_combos as $service_combo) {
                $count = $productsData[$service_combo->id]['count'];
                $condition = [
                    'patient_id' => $patient->id,
                    'item_id' => $service_combo->id,
                    'item_type' => 'Service_combo'
                ];
                $values = [
                    'patient_id' => $patient->id,
                    'item_id' => $service_combo->id,
                    'item_type' => 'Service_combo',
                    'count' => $count
                ];
                PatientService::updateOrCreate($condition, $values);
            }
        }

        $user = User::findOrFail($data['user_id']);
        if ($request->hasFile('file_check')) {
            $file = $request->file('file_check');
            Event::dispatch(new SendMailAdminEvent($user ,$file, $itemsServices));
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
}
