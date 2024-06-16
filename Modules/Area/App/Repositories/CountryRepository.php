<?php

namespace Modules\Area\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Area\App\Models\Country;
use Prettus\Repository\Eloquent\BaseRepository;

class CountryRepository extends BaseRepository
{
    public $retreivedData = [
        'id',
        'code',
        'status',
    ];
    public function model()
    {
        return Country::class;
    }
    public function getAll()
    {
        return $this->model
            ->select($this->retreivedData)
            ->withTranslation()
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
    public function getAllActive()
    {
        return $this->model
            ->select($this->retreivedData)
            ->withTranslation()
            ->where('status', Country::STATUS_ACTIVE)
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }


      /***********Trashed model SoftDeletes**************/
      public function getOnlyTrashed()
      {
          return $this->model
              ->onlyTrashed()
              ->select($this->retreivedData)
              ->filter(request()->all())
              ->orderBy('deleted_at', 'desc');
      }
      public function forceDelete(int $id)
      {
          try {
              DB::beginTransaction();
              $model = $this->model->findOrFail($id);
              $deleted = $model->forceDelete();
              DB::commit();
              return  $deleted;
          } catch (\Throwable $th) {

              DB::rollBack();
              return false;
          }
      }
      public function restore(int $id)
      {
          try {
              DB::beginTransaction();
              $model = $this->model->findOrFail($id);
              $restored = $model->restore();
              DB::commit();
              return  $restored;
          } catch (\Throwable $th) {
              DB::rollBack();
              return false;
          }
      }
      /***********Trashed model SoftDeletes**************/
}
