<?php

namespace App\Enums;

enum Layout: string
{
    case HalfScreen = 'half-screen-layout';
    case RightHalfScreen = 'right-half-screen-layout';
    case LeftHalfScreen = 'left-half-screen-layout';
    case BoxesSlide = 'boxes-slide-layout';
    case FinalSlide = 'final-slide-layout';

    public function name(): string
    {
        return match ($this) {
            self::HalfScreen => 'Default Half Screen',
            self::RightHalfScreen => 'Right Half Screen',
            self::LeftHalfScreen => 'Left Half Screen',
            self::BoxesSlide => 'Boxes',
            self::FinalSlide => 'Final Slide',
        };
    }
}
