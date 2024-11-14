<?php

namespace App\Enum;

enum EntregaStatus: string
{
    case DISPONIVEL = 'D';
    case EM_ANDAMENTO = 'A';
    case CONCLUIDO = 'C';

    public function label(): string
    {
        return match($this) {
            self::DISPONIVEL => 'disponível',
            self::EM_ANDAMENTO => 'em andamento',
            self::CONCLUIDO => 'concluído',
        };
    }
}

