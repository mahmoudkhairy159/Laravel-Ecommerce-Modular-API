<?php

namespace Modules\Item\App\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Item\App\Models\Item;
use Prettus\Repository\Eloquent\BaseRepository;

class ItemRepository extends BaseRepository
{
    public function model()
    {
        return Item::class;
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
            ->where('status', Item::STATUS_ACTIVE)
            ->orderBy('created_at', 'desc');
    }
    public function createOne(array $data)
    {
        try {
            DB::beginTransaction();

            if (request()->hasFile('image')) {
                $data['image'] = $this->uploadFile(request()->file('image'), Item::FILES_DIRECTORY);
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
                $data['image'] = $this->uploadFile(request()->file('image'), Item::FILES_DIRECTORY);
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
            // if ($item->image) {
            //     $this->deleteFile($item->image);
            // }
            // $deleted = $item->delete();
            $item->status = Item::STATUS_INACTIVE;
            $deleted = $item->save();
            DB::commit();
            return  $deleted;
        } catch (\Throwable $th) {

            DB::rollBack();
            return false;
        }
    }



    /*********************************Related_items***************************************/
    public function addRelatedItems(array $data)
    {
        try {
            DB::beginTransaction();
            $item = $this->model->findOrFail($data['itemId']);
            $item->relatedItems()->syncWithoutDetaching($data['relatedItemIds']);

            // Ensure bidirectional relationship
            foreach ($data['relatedItemIds'] as $relatedItemId) {
                $relatedItem = $this->model->findOrFail($relatedItemId);
                $relatedItem->relatedItems()->syncWithoutDetaching($data['itemId']);
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }
    public function syncRelatedItems(array $data)
    {
        try {
            DB::beginTransaction();
            $item = $this->model->findOrFail($data['itemId']);

            // Detach all old related items
            $currentRelatedItems = $item->relatedItems()->pluck('related_item_id')->toArray();
            foreach ($currentRelatedItems as $relatedItemId) {
                $relatedItem = $this->model->findOrFail($relatedItemId);
                $relatedItem->relatedItems()->detach($data['itemId']);
            }

            // Sync the new related items
            $item->relatedItems()->sync($data['relatedItemIds']);

            // Ensure bidirectional relationship
            foreach ($data['relatedItemIds'] as $relatedItemId) {
                $relatedItem = $this->model->findOrFail($relatedItemId);
                $relatedItem->relatedItems()->syncWithoutDetaching($data['itemId']);
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function removeRelatedItems( array $data)
    {
        try {
            DB::beginTransaction();
            $item = $this->model->findOrFail($data['itemId']);
            $item->relatedItems()->detach($data['relatedItemIds']);

            // Ensure bidirectional relationship
            foreach ($data['relatedItemIds'] as $relatedItemId) {
                $relatedItem = $this->model->findOrFail($relatedItemId);
                $relatedItem->relatedItems()->detach($data['itemId']);
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function getRelatedItems(Item $item, $limit = 4)
    {
        return $item->relatedItems()->inRandomOrder()->limit($limit);
    }
    /*********************************Related_items***************************************/
}
