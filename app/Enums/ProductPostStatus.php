<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Posted()
 */
final class ProductPostStatus extends Enum
{
    const Pending = 0;
    const Posted = 1;
}
