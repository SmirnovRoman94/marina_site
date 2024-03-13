<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pay\PayStoreRequest;
use App\Http\Requests\Pay\PayUpdateRequest;
use App\Models\Pay;
use Illuminate\Http\Request;
use PhpParser\Builder;

class PayController extends Controller
{
    public function store(PayStoreRequest $request)
    {
        $data = $request->validated();

        $pay = Pay::firstOrCreate($data);

        return response()->json(['mess' => 1, 'data' => $pay]);
    }

    public function index(Request $request)
    {
        $pays = Pay::when(!empty($request->input('params')), function ($query) use ($request) {
            $item = $request->input('params');
            return $query->where('active', $item);
        })
            ->get();

        return $pays;
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
