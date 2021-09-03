<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use App\Traits\ApiResponse;

class ProdutoController extends Controller
{

    use ApiResponse;

    public function index()
    {
        return $this->success(Produto::with('cardapio')->get());
    }

    public function store(ProdutoRequest $request)
    {
        $produto= Produto::create($request->all());
        return $this->success($produto,'Produto cadastrado',201);
    }

    public function show($id)
    {
        $produto= Produto::with('cardapio')->find($id);
        if (!$produto){
            return $this->error('Produto não encontrado',400);
        }
        return $this->success($produto);
    }

    public function update(ProdutoRequest $request, $id)
    {
        $produto= Produto::find($id);
        if (!$produto){
            return $this->error('Produto não encontrado',400);
        }
        $produto->update($request->all());
        return $this->success($produto,'Produto atualizado');
    }

    public function destroy($id)
    {
        $produto= Produto::find($id);
        if (!$produto){
            return $this->error('Produto não encontrado',400);
        }
        $produto->delete();
        return $this->success(null,'Produto deletado');
    }
}
