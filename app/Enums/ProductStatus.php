<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Drafted()
 * @method static static Advertised()
 * @method static static Sold()
 * @method static static Posted()
 */
final class ProductStatus extends Enum
{
    const Drafted = 0;
    const Advertised = 1;
    const Sold = 2;
    const Posted = 3;
}
