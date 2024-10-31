<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'cnpj', 'rua', 'bairro', 'numero', 'logo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
