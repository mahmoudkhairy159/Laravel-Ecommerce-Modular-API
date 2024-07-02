<?php

namespace Modules\Order\App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Order\App\Models\Discount;
use Modules\Order\App\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function model()
    {
        return Order::class;
    }
    public function getAll()
    {
        return $this->model
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }


    public function getByUserId(int $user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
    public function chnageStatus(array $data,int $id)
    {
        try {
            DB::beginTransaction();
            $order = $this->model->findOrFail($id);
            $order->status =$data['status'];
            $updated = $order->save();
            DB::commit();
            return  $updated;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
    public function deleteOne(int $id)
    {
        try {
            DB::beginTransaction();
            $order = $this->model->findOrFail($id);
            $order->status = Order::STATUS_CANCELLED;
            $deleted = $order->save();
            DB::commit();
            return  $deleted;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    //delete One By User
    public function deleteOneByUser(int $id)
    {
        try {
            DB::beginTransaction();
            $order = $this->model->where('user_id',auth()->guard('user-api')->id())->findOrFail($id);
            $order->status = Order::STATUS_CANCELLED;
            $deleted = $order->save();
            DB::commit();
            return  $deleted;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    public function applyDiscount($data)
    {
        DB::beginTransaction();

        try {
            $order = $this->model->findOrFail($data['order_id']);

            // Find the discount by code
            $discount = Discount::where('code', $data['code'])->first();

            if (!$discount || !$discount->isValid()) {
                throw new Exception(__('Invalid or expired discount code.'));
            }

            // Calculate the discount amount
            $discountAmount = 0;

            if ($discount->amount) {
                $discountAmount = $discount->amount;
            } elseif ($discount->percentage) {
                $totalPrice = $this->calculateTotalPrice($order);
                $discountAmount = ($discount->percentage / 100) * $totalPrice;
            }

            // Apply the discount to the order
            $order->discount_amount = $discountAmount;
            $order->total_price -= $discountAmount; // Update total price after discount
            $order->save();

            // Update the discount usage count
            $discount->used_count += 1;
            $discount->save();

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function calculateTotalPrice($order)
    {
        return $order->items->sum(function ($orderItem) {
            return $orderItem->item->price * $orderItem->quantity;
        });
    }

}
