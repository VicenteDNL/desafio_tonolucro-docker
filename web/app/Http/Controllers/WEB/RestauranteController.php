<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;


class RestauranteController extends Controller
{
    public function index()
    {
        try{
            $server = env('APP_SERVER_API');
            header('Content-Type: application/json');
            $ch = curl_init($server.":81/api/restaurante");
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

            $restaurantes =$result['data'];

            return view('restaurantes',compact('restaurantes'));

        }catch (\Exception $e){
            var_dump('error');exit();
        }



    }
}
