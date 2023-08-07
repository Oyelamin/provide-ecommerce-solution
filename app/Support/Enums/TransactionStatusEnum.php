<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 06/08/2023
 * Time: 9:14 pm
 */

namespace App\Support\Enums;

enum TransactionStatusEnum: int
{
    case PENDING    = 1;
    case COMPLETED  = 2;
    case FAILED     = 3;
}
