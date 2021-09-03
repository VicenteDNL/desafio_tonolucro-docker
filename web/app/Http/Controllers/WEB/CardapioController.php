<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            $error_msg = curl_error($ch);
        }
        curl_close($ch); // Feche a conexão cURL
        $result= json_decode($result, true);

        if($result==null){
            var_dump('error');exit();
        }

        if(!$result['success']){
            var_dump('error');exit();
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
