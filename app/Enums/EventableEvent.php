<?php

namespace App\Enums;

enum EventableEvent: string
{
    case OnStart = 'On Start';
    case OnComplete = 'On Complete';
    case OnUpdate = 'On Update';

    public static function toArray(): array
    {
        return [
            self::OnStart->value => self::OnStart,
            self::OnComplete->value => self::OnComplete,
            self::OnUpdate->value => self::OnUpdate,
        ];
    }
}
