<?php

namespace App\Models;

use App\Enum\EntregaStatus;
use App\Enum\TipoCarro;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'user_id',
        'titulo',
        'descricao',
        'cidade_origem',
        'cidade_destino',
        'tipo_veiculo',
        'carga',
        'percurso',
        'status',
    ];

    protected $casts = [
        'tipo_veiculo' => TipoCarro::class, // Laravel irá converter automaticamente para a enum TipoCarro
        'status' => EntregaStatus::class, // Laravel irá converter automaticamente para a enum EntregaStatus
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
