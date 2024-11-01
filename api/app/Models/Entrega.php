<?php

namespace App\Models;

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

    const TIPOS_VEICULO = [
        'Toco',
        'Truck',
        'Bitrem',
        'Rodotrem',
        'Carreta LS',
        'Carreta Baú',
        'Carreta Graneleira',
        'Caçamba',
        'Romeu e Julieta',
        'Caminhão 3/4',
        'Porta-contêiner'
    ];

    const STATUS_ENTREGA = [
        'disponivel',
        'em_andamento',
        'concluido'
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function motorista(): BelongsTo
    {
        return $this->belongsTo(Motorista::class);
    }
}
