<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 06/08/2023
 * Time: 9:05 pm
 */

namespace App\Support\Enums;

enum OrderStatusEnum: int
{
    case PENDING        = 1;
    case CANCELED       = 2;
    case COMPLETED      = 3; // Paid
    case DELIVERED      = 4;
}
