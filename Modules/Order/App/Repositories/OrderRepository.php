<?php

namespace Modules\Order\App\Repositories;

use Illuminate\Support\Facades\DB;
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

}
