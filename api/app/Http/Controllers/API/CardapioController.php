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
