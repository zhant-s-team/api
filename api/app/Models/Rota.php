<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rota extends Model
{
    use HasFactory;

    protected $table = 'rotas';

    protected $fillable = ['origem', 'destino', 'data_hora', 'paradas'];

    public $incrementing = true;

    protected $keyType = 'int';
}
