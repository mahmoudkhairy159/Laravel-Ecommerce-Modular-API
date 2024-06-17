<?php

namespace Modules\User\App\Repositories;

use App\Traits\UploadFileTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\User\App\Models\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    use UploadFileTrait;
    public function model()
    {
        return User::class;
    }
    public function getAll()
    {
        return $this->model
            ->with('profile')
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
    public function getAllActive()
    {
        return $this->model
            ->where('status', User::STATUS_ACTIVE)
            ->with('profile')
            ->filter(request()->all())
            ->orderBy('created_at', 'desc');
    }
    public function getOneByUserId(int $id)
    {
        return $this->model->with('profile')->where('id', $id)->first();
    }
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)
            ->with('profile')
            ->first();
    }
    public function findActiveBySlug(string $slug)
    {

        return $this->model
            ->where('slug', $slug)
            ->where('status', User::STATUS_ACTIVE)
            ->with('profile')
            ->first();
    }

    public function createOne(array $modelData, array  $modelProfileData)
    {

        try {
            DB::beginTransaction();
            if (request()->hasFile('image')) {
                $modelData['image'] = $this->uploadFile(request()->file('image'), User::FILES_DIRECTORY);
            }
            $created = $this->create($modelData);
            $created = $created->profile()->create($modelProfileData);
            DB::commit();
            return $created;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    public function updateOne(array $modelData, array $modelProfileData, int $id)
    {
        try {
            DB::beginTransaction();

            $model = $this->model->findOrFail($id);
            if (request()->hasFile('image')) {
                if ($model->image) {
                    $this->deleteFile($model->image,User::FILES_DIRECTORY);
                }
                $modelData['image'] = $this->uploadFile(request()->file('image'), User::FILES_DIRECTORY);
            }
            $updated = $model->update($modelData);

            if (!$updated) {
                throw new \Exception("User update failed.");
            }
            if ($model->profile) {
                $model->profile()->update($modelProfileData);
            }
            DB::commit();

            return $model->refresh();
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

            $model = $this->model->findOrFail($id);
            // if ($model->image) {
            // $this->deleteFile($model->image,User::FILES_DIRECTORY);
            // }
            // $deleted = $model->delete();
            $model->status = User::STATUS_INACTIVE;
            $deleted = $model->save();
            DB::commit();
            return  $deleted;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    //delete by user
    public function changeAccountActivity(int $id)
    {
        try {
            DB::beginTransaction();

            $model = $this->model->findOrFail($id);
            $model->active = $model->active ? User::INACTIVE : User::ACTIVE;
            $changed = $model->save();
            DB::commit();
            return  $changed;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }

    public function verify($modelId)
    {
        try {
            DB::beginTransaction();
            $this->model->where('id', $modelId)->update([
                'verified_at' => Carbon::now()
            ]);
            DB::commit();
            return true;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }


    public function updateUserProfileImage(int $id)
    {
        try {
            DB::beginTransaction();

            $model = $this->model->findOrFail($id);
            if ($model->image) {
                $this->deleteFile($model->image,User::FILES_DIRECTORY);
            }
            $modelData['image'] = $this->uploadFile(request()->file('image'), User::FILES_DIRECTORY);

            $model->update($modelData);

            DB::commit();

            return $model->refresh();
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    public function deleteUserProfileImage(int $id)
    {
        try {
            DB::beginTransaction();

            $model = $this->model->findOrFail($id);
            if ($model->image) {
                $this->deleteFile($model->image,User::FILES_DIRECTORY);
            }
            $modelData['image'] = null;
            $model->update($modelData);
            DB::commit();

            return $model->refresh();
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    public function updateGeneralPreferences(array $data, int $id)
    {
        try {
            DB::beginTransaction();

            $model = $this->model->findOrFail($id);
            if ($model->profile) {
                $model->profile()->update($data);
            }
            DB::commit();
            return $model->refresh();
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
    public function changePassword(string $newPassword, int $id)
    {
        try {
            DB::beginTransaction();

            $model = $this->model->findOrFail($id);
            $model->password = $newPassword;
            $model->save();
            DB::commit();
            return $model;
        } catch (\Throwable $e) {
            DB::rollBack();
            return false;
        }
    }



}
