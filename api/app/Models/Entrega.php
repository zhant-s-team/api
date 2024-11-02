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
        'motorista_id',
        'titulo',
        'descricao',
        'cidade_origem',
        'cidade_destino',
        'tipo_veiculo',
        'carga',
        'percurso',
        'status'
    ];


    protected function casts(): array
    {
        return [
            'tipo_veiculo' => TipoCarro::class,
            'status' => EntregaStatus::class,
        ];
    }
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function motorista(): BelongsTo
    {
        return $this->belongsTo(Motorista::class);
    }
}
