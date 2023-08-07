<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 06/08/2023
 * Time: 8:38 pm
 */

namespace App\Support\Enums;

enum ItemStatusEnum: int
{
    case ACTIVE         = 1;
    case OUT_OF_STOCK   = 2;
    case DELETED        = 3;
}
