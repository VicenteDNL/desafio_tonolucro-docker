<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;
use App\Models\Restaurante;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{

    use ApiResponse;

    public function index()
    {
        if(auth('sanctum')->user()){
            return $this->success(Produto::with('cardapio.restaurante')->get());
        }
        $produtos = Produto::where([
            'ativo' => 1,])
            ->whereIn('cardapio_id', function ($query) {
                $query->select('cardapio_id')
                    ->from('produtos')
                    ->join('cardapios', function ($join) {
                        $join->on('produtos.cardapio_id', '=', 'cardapios.id')
                            ->where('cardapios.ativo', 1);
                    })
                    ->join('restaurantes', function ($join) {
                        $join->on('cardapios.restaurante_id', '=', 'restaurantes.id')
                            ->where('restaurantes.ativo', 1);
                    });
            }
        )
        ->with('cardapio.restaurante')
        ->get();
        return $this->success($produtos);

    }

    public function store(ProdutoRequest $request)
    {
        $ativo = $request->get('ativo');
        if( !is_null($ativo) && $ativo==true ){
            if(Produto::where(['ativo'=> 1, 'cardapio_id'=>$request->get('cardapio_id')])->count()>=10){
                return $this->error('Número de produto ativos excedido',200);
            }
        }
        $produto= Produto::create($request->all());
        return $this->success($produto,'Produto cadastrado',201);
    }

    public function show($id)
    {
        if(auth('sanctum')->user()){
            $produto= Produto::where('id',$id)->with('cardapio.restaurante')->first();
        }
        else {
            $produto = Produto::where([
                'id' => $id,
                'ativo' => 1,
                'cardapio_id' => function ($query) use ($id) {
                    $query->select('cardapio_id')
                        ->from('produtos')
                        ->join('cardapios', function ($join) {
                            $join->on('produtos.cardapio_id', '=', 'cardapios.id')
                                ->where('cardapios.ativo', 1);
                        })
                        ->join('restaurantes', function ($join) {
                            $join->on('cardapios.restaurante_id', '=', 'restaurantes.id')
                                ->where('restaurantes.ativo', 1);
                        })
                        ->where('produtos.id', $id);
                }
            ])
            ->with('cardapio.restaurante')
            ->first();
        }
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

        $idCardapioRequest = $request->get('cardapio_id');
        #verifica sê está alterando o produto de cardápio
        $idCardapio = (!is_null($idCardapioRequest) && $idCardapioRequest!=$produto->cardapio_id)
             ? $idCardapioRequest
             : $produto->cardapio_id;

        $qntdAtivos = Produto::where(['ativo'=> 1, 'cardapio_id'=>$idCardapio])->count();

        $ativo = $request->get('ativo');
        if(!is_null($ativo) && $ativo==true && $qntdAtivos>=10){
            return $this->error('Número de produtos ativos excedido',200);
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
