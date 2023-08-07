<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Items\BaseControllerConfig;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Support\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ItemsController extends BaseControllerConfig
{
    use ResponseTrait;
    protected static string $guard = 'api';

    public function __construct()
    {
        $this->resourceItem = ItemResource::class;
        $this->resourceCollection = ItemCollection::class;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $collection = $this->findByFilters($request->toArray());
        return $this->respondWithCollection($collection);
    }

    /**
     * @param Request $request
     * @param Item $item
     * @return mixed
     */
    public function show(Request $request, Item $item): mixed {
        return $this->respondWithItem(
            item: $item
        );
    }

}
