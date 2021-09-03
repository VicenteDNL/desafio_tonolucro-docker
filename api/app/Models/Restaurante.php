<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'telefone',
        'endereco',
        'cep',
        'cidade',
        'estado',
    ];

    public function cardapios()
    {
        return $this->hasMany(Cardapio::class);

    }



}
