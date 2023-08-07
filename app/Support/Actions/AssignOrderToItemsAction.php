<?php
/**
 * Created by PhpStorm.
 * User: blessing
 * Date: 07/08/2023
 * Time: 2:46 am
 */

namespace App\Support\Actions;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class AssignOrderToItemsAction
{

    /**
     * @param Order $order
     * @param array $items
     * @return boolean
     */
    public static function execute(Order $order, array $items): bool
    {
        try{
            $buffer = [];
            $amount = 0.00;
            $quantity = 0;
            foreach ($items as $item){

                OrderItem::create([
                    'item_id' => $item['id'],
                    'order_id' => $order->id,
                    'quantity' => $item['quantity']
                ]);
                $itemPrice = self::getOrderItemPrice($item);
                $amount += $itemPrice;
                $quantity += $item['quantity'];
            }

            OrderItem::insert($buffer);
            $order->total_amount = $amount;
            $order->quantity = $quantity;
            $order->save();
            return true;
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return false;
        }

    }

    /**
     * @param Item $item
     * @param $quantity
     * @return float|int
     */
    private static function getOrderItemPrice(array $itemArr): float|int
    {
        $item = Item::find($itemArr['id']);
        return ($item->price * $itemArr['quantity']);
    }
}
