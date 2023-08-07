<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 06/08/2023
 * Time: 10:25 pm
 */

namespace App\Http\Controllers\Admin\Items;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Support\Interfaces\BaseControllerConfigInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseControllerConfig extends Controller implements BaseControllerConfigInterface
{
    private string $defaultSort = '-created_at';

    private array $defaultSelect = [
        '*'
    ];

    private array $allowedFilters = [
        'title',
        'status',
        'total_stocked',
        'available_stock'
    ];

    public function findByFilters(array $filterOptions): LengthAwarePaginator
    {
        $perPage = $filterOptions['limit'] ?? 20;

        return QueryBuilder::for(Item::class)->select($this->defaultSelect)->allowedFilters([
            ...$this->allowedFilters,
            AllowedFilter::scope('price_range', 'by_price_range'),
        ])->defaultSort($this->defaultSort)
            ->paginate($perPage);

    }
}
