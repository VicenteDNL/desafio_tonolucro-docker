<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;

class CardapioController extends Controller
{

    public function index($id)
    {

        $server = env('APP_SERVER_API');
        header('Content-Type: application/json');
        $ch = curl_init($server.":81/api/restaurante/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch); // Execute a instrução cURL

        if (curl_error($ch)) {
            return view('erro');
        }
        curl_close($ch); // Feche a conexão cURL
        $result= json_decode($result, true);

        if($result==null){
            return view('erro');
        }

        if(!$result['success']){
            return view('erro');
        }

        $restaurante =$result['data']['restaurante'];
        $cardapios =$result['data']['cardapios'];


        return view('cardapios',compact('cardapios','restaurante'));
    }



    public function show( $id)
    {
        //
    }



}
