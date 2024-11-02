<?php

namespace App\Enum;

enum EntregaStatus
{
    case  DISPONIVEL = 'D';
    case EM_ANDAMENTO = 'A';
    case CONCLUIDO = 'C';


    public function label(): string{
        return match($this){
            self::DISPONIVEL => 'disponivel',
            self::EM_ANDAMENTO => 'em_andamento',
            self::CONCLUIDO => 'concluido'
        };
    }
}
