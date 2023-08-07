<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 06/08/2023
 * Time: 10:17 pm
 */

namespace App\Support\Enums;

/**
 *  This should be set on a table where name and sign is declared but only on a production level application.
 *  This is permitted because it's a test.
 */
enum CurrencyEnum: string
{
    case DOLLAR = '$';
}
