<?php

namespace Modules\Item\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Item\App\Models\ItemImage;
use Prettus\Repository\Eloquent\BaseRepository;

class ItemImageRepository extends BaseRepository
{
    public function model()
    {
        return ItemImage::class;
    }
    public function getByItemId($item_id)
    {
        return $this->model
        ->where('item_id', $item_id)
        ->orderBy('created_at', 'desc');
    }

    public function createOne(array $data)
    {
        try {
            DB::beginTransaction();

            if (request()->hasFile('image')) {
                $data['image'] = $this->uploadFile(request()->file('image'), ItemImage::FILES_DIRECTORY);
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
            $item = $this->model->findOrFail($id);
            if (request()->hasFile('image')) {
                if ($item->image) {
                    $this->deleteFile($item->image);
                }
                $data['image'] = $this->uploadFile(request()->file('image'), ItemImage::FILES_DIRECTORY);
            }
            $updated = $item->update($data);

            DB::commit();

            return $item->refresh();
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
    //delete by item
    public function deleteOne(int $id)
    {
        try {
            DB::beginTransaction();

            $item = $this->model->findOrFail($id);
            if ($item->image) {
                $this->deleteFile($item->image);
            }
            $deleted = $item->delete();
            DB::commit();
            return  $deleted;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }
}
