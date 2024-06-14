<?php

namespace Modules\Category\App\Repositories;

use App\Traits\UploadFileTrait;
use Illuminate\Support\Facades\DB;
use Modules\Category\App\Models\Category;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{
    use UploadFileTrait;
    public function model()
    {
        return Category::class;
    }
    public function getAll()
    {
        return $this->model
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
    public function getAllActive()
    {
        return $this->model
            ->filter(request()->all())
            ->where('status', Category::STATUS_ACTIVE)
            ->orderBy('created_at', 'desc');
    }
    public function createOne(array $data)
    {
        try {
            DB::beginTransaction();

            if (request()->hasFile('image')) {
                $data['image'] = $this->uploadFile(request()->file('image'), Category::FILES_DIRECTORY);
            }
            $created = $this->model->create($data);
            DB::commit();

            return $created;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }

    public function updateOne(array $data, int $id)
    {
        try {
            DB::beginTransaction();

           $model = $this->model->findOrFail($id);
            if (request()->hasFile('image')) {
                if ($model->image) {
                    $this->deleteFile($model->image,Category::FILES_DIRECTORY);
                }
                $data['image'] = $this->uploadFile(request()->file('image'), Category::FILES_DIRECTORY);
            }
            $updated =$model->update($data);
            DB::commit();
            return $updated;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    public function deleteOne(int $id)
    {
        try {
            DB::beginTransaction();
           $model = $this->model->findOrFail($id);
            // if ($model->image) {
            //     $this->deleteFile($model->image);
            // }
            $deleted =$model->delete();
            DB::commit();
            return  $deleted;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }

    /***********Trashed model SoftDeletes**************/
    public function getOnlyTrashed()
    {
        return $this->model
            ->onlyTrashed()
            ->filter(request()->all())
            ->orderBy('deleted_at', 'desc');
    }
    public function forceDelete(int $id)
    {
        try {
            DB::beginTransaction();
            $model = $this->model->findOrFail($id);
            if ($model->image) {
                $this->deleteFile($model->image,Category::FILES_DIRECTORY);
            }
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
