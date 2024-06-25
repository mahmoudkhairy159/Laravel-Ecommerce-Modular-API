<?php

namespace Modules\Item\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Item\App\Repositories\ItemImageRepository;
use Modules\Item\App\resources\ItemImage\ItemImageResource;
use Modules\Item\App\Http\Requests\Admin\ItemImage\StoreItemImageRequest;
use Modules\Item\App\Http\Requests\Admin\ItemImage\UpdateItemImageRequest;
use Modules\Item\App\resources\ItemImage\ItemImageCollection;

class ItemImageController extends Controller
{
    use ApiResponseTrait;
    protected $itemImageRepository;
    protected $_config;
    protected $guard;
    public function __construct(ItemImageRepository $itemImageRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->itemImageRepository = $itemImageRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:itemImages.show'])->only(['getByItemId', 'show']);
        $this->middleware(['permission:itemImages.create'])->only(['store']);
        $this->middleware(['permission:itemImages.update'])->only(['update']);
        $this->middleware(['permission:itemImages.destroy'])->only(['destroy']);
    }
    /**Introduction
    Issues
    Changelog
    FAQ

     * Display a listing of the resource.
     */
    public function getByItemId($item_id)
    {
        try {
            $data = $this->itemImageRepository->getByItemId($item_id)->paginate();
            return $this->successResponse(new ItemImageCollection($data));
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
    public function store(StoreItemImageRequest $request)
    {
        try {
            $data =  $request->validated();
            $data['created_by'] = auth()->guard($this->guard)->id();
            $created = $this->itemImageRepository->createOne($data);

            if ($created) {
                return $this->messageResponse(
                    __("item::app.itemImages.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("item::app.itemImages.created-failed"),
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
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->itemImageRepository->findOrFail($id);
            return $this->successResponse(new ItemImageResource($data));
        } catch (Exception $e) {
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
    public function update(UpdateItemImageRequest $request, $id)
    {
        try {

            $data =  $request->validated();
            $data['updated_by'] = auth()->guard($this->guard)->id();
            $updated = $this->itemImageRepository->updateOne($data, $id);
            if ($updated) {
                return $this->messageResponse(
                    __("item::app.itemImages.updated-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("item::app.itemImages.updated-failed"),
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
    public function destroy($id)
    {
        try {
            $deleted = $this->itemImageRepository->deleteOne($id);
            if ($deleted) {
                return $this->messageResponse(
                    __("item::app.itemImages.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("item::app.itemImages.deleted-failed"),
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
