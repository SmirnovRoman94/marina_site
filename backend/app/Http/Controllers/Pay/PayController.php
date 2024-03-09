<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pay\PayStoreRequest;
use App\Http\Requests\Pay\PayUpdateRequest;
use App\Models\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function store(PayStoreRequest $request)
    {
        $data = $request->validated();

        $pay = Pay::firstOrCreate($data);

        return response()->json(['mess' => 1, 'data' => $pay]);
    }

    public function index()
    {
        return Pay::all();
    }

    public function update(PayUpdateRequest $request, Pay $pay)
    {
        $data = $request->validated();

        $pay->update($data);

        return response()->json(['mess' => 1, 'data' => $pay]);
    }

    public function destroy(Pay $pay)
    {
        $pay->delete();
        return response()->json(['mess' => 1, 'data' => '']);
    }

    public function show(Pay $pay)
    {
        return response()->json(['mess' => 1, 'data' => $pay]);
    }
}
