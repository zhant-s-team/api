<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viagem extends Model
{
    use HasFactory;

    // Define a tabela associada ao modelo
    protected $table = 'viagens';

    // Permite a atribuição em massa para os campos especificados
    protected $fillable = [
        'rota_id',
        'veiculo_id',
        'motorista_id',
        'cargas_id',
        'data_hora',
        'status',
    ];

    // Indica que a chave primária é auto-incrementável
    public $incrementing = true;

    // Especifica que o tipo da chave primária é inteiro
    protected $keyType = 'int';

    // Relacionamento com a tabela Veículos
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_id');
    }

    // Relacionamento com a tabela Motoristas
    public function motorista()
    {
        return $this->belongsTo(Motorista::class, 'motorista_id');
    }

    // Relacionamento com a tabela Rotas (caso esteja envolvida no contexto do sistema)
    public function rota()
    {
        return $this->belongsTo(Rota::class, 'rota_id');
    }

    public function cargas()
    {
        return $this->belongsTo(carga::class, 'cargas_id');
    }
}
