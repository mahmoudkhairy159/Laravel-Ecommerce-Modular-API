<?php

namespace Modules\Item\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Item\App\Repositories\ItemRepository;
use Modules\Item\App\resources\Item\ItemResource;

class RelatedItemController extends Controller
{
    use ApiResponseTrait;
    protected $itemRepository;
    protected $_config;
    protected $guard;
    public function __construct(ItemRepository $itemRepository)
    {
        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->itemRepository = $itemRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);

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



    
}
