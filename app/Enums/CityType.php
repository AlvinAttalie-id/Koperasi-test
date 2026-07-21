<?php

declare(strict_types=1);

namespace App\Enums;

enum CityType: string
{
    case Kabupaten = 'kabupaten';
    case Kota = 'kota';
}
