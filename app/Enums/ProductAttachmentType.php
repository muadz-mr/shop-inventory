<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Image()
 * @method static static Video()
 */
final class ProductAttachmentType extends Enum
{
    const Image = 1;
    const Video = 2;
}
