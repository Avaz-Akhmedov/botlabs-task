<?php

namespace App\Enums;

enum LeadStatusEnum: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case WON = 'won';
    case LOST = 'lost';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
