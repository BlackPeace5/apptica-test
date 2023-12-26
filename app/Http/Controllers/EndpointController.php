<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Endpoint;

class EndpointController extends Controller
{
    public function index(Request $request) {
        Log::info(['user_ip'=> $request->ip(), 'request_data' => $request->all()]);

        $val = Validator::make($request->all(), [
            "date"=> "required|date",
        ]);

        if ($val->fails()) {
            return response()->json(['status' => 404, 'message' => 'Date invalid'], 404);
        }

        $endpoint = Endpoint::whereDate('created_at', $request->date)
            ->where(['application_id' => 1421444, 'country_id' => 1])
            ->first();

        if (empty($endpoint)) {
            return response()->json(['status' => 404, 'message' => 'Data not found'], 404);
        }

        return response()->json(['status'=> 200, 'message'=> 'ok', 'data' => $endpoint['data']], 200);
    }
}
