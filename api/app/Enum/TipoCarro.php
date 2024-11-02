<?php

namespace App\Enum;

enum TipoCarro
{
    case TOCO = 'TC';
    case BITREM = 'BT';
    case RODOTREM = 'RT';
    case BAU = 'BU';
    case TRESQUARTO = 'TQ';

    public function label(): string{
        return match($this){
            self::TOCO => 'Truck',
            self::BITREM => 'Bitrem',
            self::RODOTREM => 'Rodotrem',
            self::BAU => 'Carreta Bau',
            self::TRESQUARTO => 'Caminhão 3/4'
        };
    }
}
