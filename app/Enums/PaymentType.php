<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Paysera()
 * @method static static Cash()
 */
final class PaymentType extends Enum
{
    const Paysera = 0;
    const Cash = 1;
}
