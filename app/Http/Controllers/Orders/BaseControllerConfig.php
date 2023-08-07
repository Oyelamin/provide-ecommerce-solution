<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 07/08/2023
 * Time: 2:00 am
 */

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Support\Interfaces\BaseControllerConfigInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BaseControllerConfig extends Controller implements BaseControllerConfigInterface
{
    private string $defaultSort = '-created_at';

    private array $defaultSelect = [
        '*'
    ];

    private array $allowedFilters = [
        'status',
        'contact',
        'address'
    ];

    public function findByFilters(array $filterOptions): LengthAwarePaginator
    {
        $perPage = $filterOptions['limit'] ?? 20;
        return QueryBuilder::for(Order::class)->select($this->defaultSelect)->allowedFilters([
            ...$this->allowedFilters,
        ])->defaultSort($this->defaultSort)
            ->paginate($perPage);
    }

}
