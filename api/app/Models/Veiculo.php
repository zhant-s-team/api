<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

    protected $fillable = ['tipo', 'capacidade', 'status', 'placa'];

    public $incrementing = true;

    protected $keyType = 'int';
}
