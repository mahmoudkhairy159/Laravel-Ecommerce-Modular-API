<?php

namespace Modules\Admin\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\App\Models\Admin;
use Prettus\Repository\Eloquent\BaseRepository;

class AdminRepository extends BaseRepository
{
    public function model()
    {
        return Admin::class;
    }
    public function getAll()
    {
        return $this->model
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
  
    public function updateOne(array $data, int $id)
    {
        try {
            DB::beginTransaction();
            $admin = $this->model->findOrFail($id);
            if (request()->hasFile('image')) {
                if ($admin->image) {
                    $this->deleteFile($admin->image);
                }
                $data['image'] = $this->uploadFile(request()->file('image'), Admin::FILES_DIRECTORY);
            }
            $updated = $admin->update($data);
           
            DB::commit();

            return $admin->refresh();
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    //delete by admin
    public function deleteOne(int $id)
    {
        try {
            DB::beginTransaction();

            $admin = $this->model->findOrFail($id);
            // if ($admin->image) {
            //     $this->deleteFile($admin->image);
            // }
            // $deleted = $admin->delete();
            $admin->status=Admin::STATUS_INACTIVE;
            $deleted=$admin->save();
            DB::commit();
            return  $deleted;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
}
