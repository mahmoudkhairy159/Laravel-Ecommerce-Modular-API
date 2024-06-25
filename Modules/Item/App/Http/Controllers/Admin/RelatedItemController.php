<?php

namespace Modules\Item\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Item\App\Repositories\ItemRepository;
use Modules\Item\App\resources\Item\ItemResource;
use Modules\Item\App\Http\Requests\Admin\RelatedItem\DeleteRelatedItemsRequest;
use Modules\Item\App\Http\Requests\Admin\RelatedItem\StoreRelatedItemsRequest;
use Modules\Item\App\Http\Requests\Admin\RelatedItem\UpdateRelatedItemsRequest;

class RelatedItemController extends Controller
{
    use ApiResponseTrait;
    protected $itemRepository;
    protected $_config;
    protected $guard;
    public function __construct(ItemRepository $itemRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->itemRepository = $itemRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:relatedItems.show'])->only(['getRelatedItems']);
        $this->middleware(['permission:relatedItems.create'])->only(['store']);
        $this->middleware(['permission:relatedItems.update'])->only(['update']);
        $this->middleware(['permission:relatedItems.destroy'])->only(['destroy']);
    }
    /**Introduction
    Issues
    Changelog
    FAQ

     * Display a listing of the resource.
     */
    public function  getRelatedItems($itemId)
    {
        try {
            $item = $this->itemRepository->findOrFail($itemId);
            $data = $this->itemRepository->getRelatedItems($item, 4)->get();
            return $this->successResponse(ItemResource::Collection($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRelatedItemsRequest $request)
    {
        try {
            $data =  $request->validated();
            $created = $this->itemRepository->addRelatedItems($data);

            if ($created) {
                return $this->messageResponse(
                    __("item::app.relatedItems.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("item::app.relatedItems.created-failed"),
                    false,
                    400
                );
            }
        } catch (Exception $e) {
            //    return  $this->messageResponse( $e->getMessage());
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRelatedItemsRequest $request, $id)
    {
        try {

            $data =  $request->validated();
            $updated = $this->itemRepository->syncRelatedItems($$data);
            if ($updated) {
                return $this->messageResponse(
                    __("item::app.relatedItems.updated-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("item::app.relatedItems.updated-failed"),
                    false,
                    400
                );
            }
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteRelatedItemsRequest $request)
    {
        try {
            $data =  $request->validated();
            $deleted = $this->itemRepository->removeRelatedItems($$data);
            if ($deleted) {
                return $this->messageResponse(
                    __("item::app.relatedItems.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("item::app.relatedItems.deleted-failed"),
                    false,
                    400
                );
            }
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }
}
