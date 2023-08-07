<?php

namespace App\Http\Controllers\Admin\Items;

use App\Http\Requests\CreateItemApiRequest;
use App\Http\Requests\ItemRestockApiRequest;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Support\Enums\CurrencyEnum;
use App\Support\Enums\ItemStatusEnum;
use App\Support\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ItemsController extends BaseControllerConfig
{
    use ResponseTrait;
    protected static string $guard = 'admin_api';

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
     * @param CreateItemApiRequest $request
     * @return mixed
     */
    public function create(CreateItemApiRequest $request): mixed
    {
        try{
            $admin = Auth::guard(self::$guard)->user();
            $requestData = $request->only(['title', 'description', 'price']);

            $quantity = $request->quantity;
            $item = Item::create([
                ...$requestData,
                'status' => ItemStatusEnum::ACTIVE->value,
                'currency' => CurrencyEnum::DOLLAR->value,
                'admin_id' => $admin->id,
                'last_stocked' => now(),
                'total_stocked' => $quantity,
                'available_stock' => $quantity
            ]);

            return $this->respondWithItem(item: $item);
        }catch (\Exception $e) {

            return $this->respondWithError(
                message: "Something went wrong while creating an item. Kindly try again later.",
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

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

    public function restock(ItemRestockApiRequest $request, Item $item)
    {
        try{
            $quantity = $request->quantity;
            $item->increment('total_stocked', $quantity);
            $item->increment('available_stock', $quantity);
            $item->save();
            $item->refresh();
            return $this->respondWithItem(
                item: $item
            );
        }catch (\Exception $e) {
            return $this->respondWithError(
                message: "Something went wrong while restocking an item. Kindly try again later.",
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    public function update(CreateItemApiRequest $request, Item $item): mixed
    {
        try{
            $requestData = $request->only(['title', 'description', 'price']);

            $quantity = $request->quantity;
            $item->update([
                ...$requestData,
                'total_stocked' => $quantity,
                'available_stock' => $quantity
            ]);

            return $this->respondWithNoContent(
                message: "Item has been updated successfully."
            );

        }catch (\Exception $e) {
            return $this->respondWithError(
                message: "Something went wrong while updating an item. Kindly try again later.",
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }



}
