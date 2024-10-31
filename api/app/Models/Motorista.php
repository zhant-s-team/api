<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Motorista extends Model
{
    use HasFactory;

    // Define a tabela associada ao modelo
    protected $table = 'motoristas';

    protected $fillable = ['user_id', 'cnh'];

    // Indica que a chave primária não é auto-incrementável
    public $incrementing = true;

    // Especifica que o tipo da chave primária é inteiro
    protected $keyType = 'int';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
