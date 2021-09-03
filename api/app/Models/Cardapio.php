<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'restaurante_id',
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }

    public function produtos()
    {
        return $this->hasMany(Produto::class);

    }
}
