<?php
namespace App\Enums;

enum GenderEnum: string
{
    case Male = 'm';
    case Female = 'f';
    public function label(): string
    {
        return match ($this) {
            static::Male   => 'Maculino',
            static::Female => 'Femenino',
        };
    }
}