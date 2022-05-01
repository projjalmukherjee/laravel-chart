<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BitcoinController extends Controller
{
    //


    public function callchartApi(Request $request){

        $start = $request->input('start_date');//'2021-03-01';
        $end = $request->input('end_date');//'2022-04-01';
        $response = Http::get('https://api.coindesk.com/v1/bpi/historical/close.json',[
            'start'=>$start,
            'end'=>$end,
            'index'=>'USD'
        ]);
        $level_arr = [];
        $bitcoin_arr = [];

        if($response->getStatusCode() == '200') {

            $data_arr = $response->json();
            $level_arr  = array_keys($data_arr['bpi']);
            $bitcoin_arr = array_values($data_arr['bpi']);
        }
        
        $result_data = ['data'=>['yaxis'=>$level_arr,'xaxis'=>$bitcoin_arr]];
        return response()->json($result_data);
    }
}
