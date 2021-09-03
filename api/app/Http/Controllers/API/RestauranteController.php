<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestauranteRequest;
use App\Models\Restaurante;
use App\Traits\ApiResponse;

class RestauranteController extends Controller
{

    use ApiResponse;


    public function index()
    {
        return $this->success(Restaurante::all());
    }

    public function store(RestauranteRequest $request)
    {
        $restaurante= Restaurante::create($request->all());
        return $this->success($restaurante,'Restaurante cadastrado',201);
    }

    public function show($id)
    {
        $restaurante= Restaurante::find($id);
        if (!$restaurante){
            return $this->error('Restaurante não encontrado',400);
        }
        $cardapios = $restaurante->cardapios()->with('produtos')->get();
        return $this->success(['restaurante'=>$restaurante,'cardapios'=>$cardapios]);
    }

    public function update(RestauranteRequest $request, $id)
    {
        $restaurante= Restaurante::find($id);
        if (!$restaurante){
            return $this->error('Restaurante não encontrado',400);
        }
        $restaurante->update($request->all());
        return $this->success($restaurante,'Restaurante atualizado');
    }

    public function destroy($id)
    {
        $restaurante= Restaurante::find($id);
        if (!$restaurante){
            return $this->error('Restaurante não encontrado',400);
        }
        $restaurante->delete();
        return $this->success(null,'Restaurante deletado');
    }
}
