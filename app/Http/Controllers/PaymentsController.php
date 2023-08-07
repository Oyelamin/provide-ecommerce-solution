<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderPaymentApiRequest;
use App\Models\Order;
use App\Models\Transaction;
use App\Support\Enums\OrderStatusEnum;
use App\Support\Enums\TransactionStatusEnum;
use App\Support\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    use ResponseTrait;
    protected static string $guard = 'api';

    public function payForOrder(OrderPaymentApiRequest $request) {
        try{
            $user = Auth::guard(self::$guard)->user();
            $order = $request->order_id;
            $amount_paid = $request->amount_paid;
            $order = Order::find($order);
            if(!$order){
                throw new \Error('Order is not found.');
            }
            if($order->total_amount < $amount_paid){
                throw new \Error("Amount paid is less than the order total amount. Total amount of your order is {$order->total_amount}.");
            }
            $statuses  = [
                TransactionStatusEnum::COMPLETED,
                TransactionStatusEnum::FAILED,
            ];

            $randomTransactionStatus = $statuses[array_rand($statuses)];

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount_paid' => $amount_paid,
                'status' => $randomTransactionStatus->value
            ]);

            if($transaction->status !== TransactionStatusEnum::COMPLETED->value){
                throw new \Error('Transaction was not successful. Kindly try again later.');
            }

            $order->status = OrderStatusEnum::COMPLETED->value;
            $order->save();

            return $this->respondWithNoContent(message: "Payment was made successfully.");

        }catch(\Error $e){
            return $this->respondWithError(
                message: $e->getMessage()
            );
        }catch(\Exception $e){
            return $this->respondWithError(
                message: "Something went wrong while making payment. Kindly try again later.",
                status_code: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }
}
