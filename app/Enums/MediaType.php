<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class MediaType extends Enum
{
    const Img =   0;
    const Video =   1;
    const Audio = 2;
    const Thumbnail = 3;
}
