<?php

namespace Modules\Cart\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\App\Http\Requests\Api\Cart\AddToCartRequest;
use Modules\Cart\App\Http\Requests\Api\Cart\UpdateItemQuantityRequest;
use Modules\Cart\App\Repositories\CartRepository;
use Modules\Cart\App\resources\CartItem\CartItemCollection;

class CartController extends Controller
{
    use ApiResponseTrait;
    protected $cartRepository;
    protected $_config;
    protected $guard;
    public function __construct(CartRepository $cartRepository)
    {
        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->cartRepository = $cartRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
    }


    public function viewCart()
    {
        try {
            $data = $this->cartRepository->getItems()->paginate();
            return $this->successResponse(new CartItemCollection($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }
    public function addToCart(AddToCartRequest $request)
    {
        try {
            $data = $request->validated();
            $added = $this->cartRepository->addItem($data);

            if ($added) {
                return $this->messageResponse(
                    __("cart::app.carts.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("cart::app.carts.created-failed"),
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


    public function removeFromCart($itemId)
    {
        try {
            $removed = $this->cartRepository->removeItem($itemId);
            if ($removed) {
                return $this->messageResponse(
                    __("cart::app.carts.deleted-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("cart::app.carts.deleted-failed"),
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




    public function updateItemQuantity(UpdateItemQuantityRequest $request, $itemId)
    {
        try {
            $data = $request->validated();
            $updated=$this->cartRepository->updateItemQuantity($itemId, $data);
            if ($updated) {
                return $this->messageResponse(
                    __("cart::app.carts.updated-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("cart::app.carts.updated-failed"),
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
