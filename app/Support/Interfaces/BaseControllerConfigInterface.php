<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 06/08/2023
 * Time: 10:31 pm
 */

namespace App\Support\Interfaces;

interface BaseControllerConfigInterface
{
    /**
     * @param array $filterOptions
     * @return mixed
     */
    public function findByFilters(array $filterOptions): object;
}
