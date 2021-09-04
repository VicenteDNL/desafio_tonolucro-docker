<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardapioRequest;
use App\Models\Cardapio;
use App\Traits\ApiResponse;

class CardapioController extends Controller
{

    use ApiResponse;

    public function index()
    {
        return $this->success(Cardapio::with('restaurante')->get());
    }

    public function store(CardapioRequest $request)
    {
        $ativo = $request->get('ativo');
        if( !is_null($ativo) && $ativo==true ){
            if(Cardapio::where(['ativo'=> 1, 'restaurante_id'=>$request->get('restaurante_id')])->count()>=3){
                return $this->error('Número de cadapios ativos excedido',200);
            }
        }

        $cardapio= Cardapio::create($request->all());
        return $this->success($cardapio,'Cardápio cadastrado',201);
    }

    public function show($id)
    {
        $cardapio= Cardapio::with('restaurante')->find($id);
        if (!$cardapio){
            return $this->error('Cardápio não encontrado',400);
        }
        return $this->success($cardapio);
    }

    public function update(CardapioRequest $request, $id)
    {
        $cardapio= Cardapio::find($id);
        if (!$cardapio){
            return $this->error('Cardápio não encontrado',400);
        }

        $idRestauranteRequest = $request->get('restaurante_id');

        $idCardapio = (!is_null($idRestauranteRequest) && $idRestauranteRequest!=$cardapio->restaurante_id)
            ? $request->get('restaurante_id')
            : $cardapio->restaurante_id;

        $qntdAtivos = Cardapio::where(['ativo'=> 1, 'restaurante_id'=>$idCardapio])->count();

        $ativo = $request->get('ativo');
        if(!is_null($ativo) && $ativo==true && $qntdAtivos>=3){
            return $this->error('Número de cardápios ativos excedido',200);
        }

        $cardapio->update($request->all());
        return $this->success($cardapio,'Cardápio atualizado');
    }

    public function destroy($id)
    {
        $cardapio= Cardapio::find($id);
        if (!$cardapio){
            return $this->error('Cardápio não encontrado',400);
        }
        $cardapio->delete();
        return $this->success(null,'Cardápio deletado');
    }
}
