<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class LocationType extends Enum
{
    const BusStation =   0;
    const Self =   1;   // DONE
    const Office = 2;
    const Faculty = 3;  // DONE
    const SportField = 4;
    const Entrance = 5; // DONE
    const Bus = 6;
}
