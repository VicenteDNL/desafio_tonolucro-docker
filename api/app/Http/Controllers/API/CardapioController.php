<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardapioRequest;
use App\Models\Cardapio;
use App\Models\Restaurante;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;

class CardapioController extends Controller
{

    use ApiResponse;

    public function index()
    {
        if(auth('sanctum')->user()){
            return $this->success(Cardapio::with('restaurante')->get());
        }
        $cardapios = Cardapio::where([
            'ativo' => 1,])
            ->whereIn('restaurante_id', function ($query) {
                $query->select('restaurante_id')
                    ->from('cardapios')
                    ->join('restaurantes', function ($join) {
                        $join->on('cardapios.restaurante_id', '=', 'restaurantes.id')
                            ->where('restaurantes.ativo', 1);
                    });
            })
            ->with('restaurante')
            ->get();
        return $this->success($cardapios);
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
        if(auth('sanctum')->user()){
            $cardapio= Cardapio::with('restaurante')->find($id);
        }
        else{
            $cardapio = Cardapio::where([
                'ativo' => 1,])
                ->whereIn('restaurante_id', function ($query) use ($id) {
                    $query->select('restaurante_id')
                        ->from('cardapios')
                        ->join('restaurantes', function ($join) {
                            $join->on('cardapios.restaurante_id', '=', 'restaurantes.id')
                                ->where('restaurantes.ativo', 1);
                        })
                        ->where('cardapios.id', $id);
                })
                ->with('restaurante')
                ->get();
        }
        if(!$cardapio){
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
