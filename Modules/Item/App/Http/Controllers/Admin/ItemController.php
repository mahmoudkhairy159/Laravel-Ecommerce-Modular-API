<?php

namespace Modules\Item\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Item\App\Repositories\ItemRepository;
use Modules\Item\App\resources\Item\ItemResource;
use Modules\Item\App\Http\Requests\Admin\Item\StoreItemRequest;
use Modules\Item\App\Http\Requests\Admin\Item\UpdateItemRequest;
use Modules\Item\App\resources\Item\ItemCollection;

class ItemController extends Controller
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
        $this->middleware(['permission:items.show'])->only(['index', 'show']);
        $this->middleware(['permission:items.create'])->only(['store']);
        $this->middleware(['permission:items.update'])->only(['update']);
        $this->middleware(['permission:items.destroy'])->only(['destroy']);
    }
    /**Introduction
    Issues
    Changelog
    FAQ

     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->itemRepository->getAll()->paginate();
            return $this->successResponse(new ItemCollection($data));
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
    public function store(StoreItemRequest $request)
    {
        try {
            $data =  $request->validated();
            $data['created_by'] = auth()->guard($this->guard)->id();
            $created = $this->itemRepository->createOne($data);

            if ($created) {
                return $this->messageResponse(
                    __("item::app.items.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("item::app.items.created-failed"),
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
     * Show the specified resource.
     */
    public function show($id)
    {
        try {
            $data = $this->itemRepository->findOrFail($id);
            return $this->successResponse(new ItemResource($data));
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
    public function update(UpdateItemRequest $request, $id)
    {
        try {

            $data =  $request->validated();
            $data['updated_by'] = auth()->guard($this->guard)->id();
            $updated = $this->itemRepository->updateOne($data, $id);
            if ($updated) {
                return $this->messageResponse(
                    __("item::app.items.updated-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("item::app.items.updated-failed"),
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
            $deleted = $this->itemRepository->deleteOne($id);
            if ($deleted) {
                return $this->messageResponse(
                    __("item::app.items.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("item::app.items.deleted-failed"),
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
