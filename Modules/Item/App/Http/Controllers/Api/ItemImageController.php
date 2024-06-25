<?php

namespace Modules\Item\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Item\App\Repositories\ItemImageRepository;
use Modules\Item\App\resources\ItemImage\ItemImageResource;
use Modules\Item\App\resources\ItemImage\ItemImageCollection;

class ItemImageController extends Controller
{
    use ApiResponseTrait;
    protected $itemImageRepository;
    protected $_config;
    protected $guard;
    public function __construct(ItemImageRepository $itemImageRepository)
    {
        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->itemImageRepository = $itemImageRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
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
}
