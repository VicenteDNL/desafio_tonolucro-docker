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
        if(auth('sanctum')->user()){
            return $this->success(Restaurante::all());
        }
        return $this->success(Restaurante::firstWhere('ativo',1));
    }

    public function store(RestauranteRequest $request)
    {
        $restaurante= Restaurante::create($request->all());
        return $this->success($restaurante,'Restaurante cadastrado',201);
    }

    public function show($id)
    {
        if(auth('sanctum')->user()){
            $restaurante= Restaurante::find($id);
        }
        else{
            $restaurante= Restaurante::firstWhere(['id'=>$id,'ativo'=>1]);
        }

        if (!$restaurante){
            return $this->error('Restaurante não encontrado',400);
        }

        if(auth('sanctum')->user()){
            $cardapios = $restaurante->cardapios()->with('produtos')->get();
        }
        else{
            $cardapios = $restaurante->cardapios()->where('ativo', 1)->with(['produtos'=>function ($query){
                $query->where('produtos.ativo', 1);
            }])->get();
        }
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
