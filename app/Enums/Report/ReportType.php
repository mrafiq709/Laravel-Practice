<?php
/**
 * Copyright (c) 2021.
 * Rafiq
 */

namespace App\Enums\Report;

use BenSampo\Enum\Enum;

/**
 * @method static static WEEKLY()
 * @method static static MONTHLY()
 */
class ReportType extends Enum
{
    const WEEKLY = 0;
    const MONTHLY = 1;
}
