<?php

namespace App\Enums;

enum CallResultEnum: string
{
    case NO_ANSWER = 'no_answer';
    case CALLBACK_LATER = 'callback_later';
    case SUCCESS = 'success';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
