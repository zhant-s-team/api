<?php

namespace App\Enum;

enum TipoCarro: string
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

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}

