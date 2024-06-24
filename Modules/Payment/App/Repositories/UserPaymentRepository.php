<?php

namespace Modules\Payment\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Payment\App\Models\UserPayment;
use Prettus\Repository\Eloquent\BaseRepository;

class UserPaymentRepository extends BaseRepository
{
    public function model()
    {
        return UserPayment::class;
    }
    public function getAll()
    {
        return $this->model
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }

    public function getByUserId($user_id)
    {
        return $this->model
            ->where('user_id',$user_id)
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
    public function getActiveByUserId($user_id)
    {
        return $this->model
        ->where('status',UserPayment::STATUS_ACTIVE)
            ->where('user_id',$user_id)
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
     //delete by admin
     public function deleteOne(int $id)
     {
         try {
             DB::beginTransaction();

             $model = $this->model->findOrFail($id);

             $model->status = UserPayment::STATUS_INACTIVE;
             $deleted = $model->save();
             DB::commit();
             return  $deleted;
         } catch (\Throwable $th) {

             DB::rollBack();
             return false;
         }
     }
     //delete by user
     public function changePaymentActivity(int $id)
     {
         try {
             DB::beginTransaction();

             $model = $this->model->findOrFail($id);
             $model->active = $model->active ? UserPayment::INACTIVE : UserPayment::ACTIVE;
             $changed = $model->save();
             DB::commit();
             return  $changed;
         } catch (\Throwable $th) {

             DB::rollBack();
             return false;
         }
     }
     public function isPaymentOwner($user_id,$id)
     {
             return  $this->model->where('id',$id)->where('user_id',$user_id)->exists();
     }


}
