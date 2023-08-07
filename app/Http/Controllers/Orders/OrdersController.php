<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderApiRequest;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Support\Actions\AssignOrderToItemsAction;
use App\Support\Enums\OrderStatusEnum;
use App\Support\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrdersController extends BaseControllerConfig
{
    use ResponseTrait;
    protected static string $guard = 'api';

    public function __construct()
    {
        $this->resourceItem = OrderResource::class;
        $this->resourceCollection = OrderCollection::class;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed {
        $collection = $this->findByFilters($request->toArray());
        return $this->respondWithCollection($collection);
    }

    /**
     * @param CreateOrderApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateOrderApiRequest $request): mixed {
        try{
            $user = Auth::guard(self::$guard)->user();
            $order = Order::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'contact' => $request->contact,
                'status' => OrderStatusEnum::PENDING->value
            ]);
            if(!AssignOrderToItemsAction::execute($order, $request->items)){
                throw new \Error('Order was created but unable to assign items. Kindly update to add items.');
            }

            return $this->respondWithNoContent(message: "Order was created successful.");

        }catch(\Error $e){
            return $this->respondWithError(
                message: $e->getMessage()
            );
        }catch(\Exception $e){
            return $this->respondWithError(
                message: "Something went wrong while creating an order. Kindly try again later.",
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function show(Order $order): mixed
    {
        return $this->respondWithItem(
            item: $order
        );
    }

}
