<?php

namespace Modules\Cart\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\App\Repositories\CartRepository;
use Modules\Cart\App\resources\Cart\CartResource;
use Modules\Cart\App\Http\Requests\Admin\Cart\UpdateUserCartRequest;
use Modules\Cart\App\resources\Cart\CartCollection;

class CartController extends Controller
{
    use ApiResponseTrait;
    protected $cartRepository;
    protected $_config;
    protected $guard;
    public function __construct(CartRepository $cartRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->cartRepository = $cartRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:carts.show'])->only(['index', 'show']);
        $this->middleware(['permission:carts.create'])->only(['store']);
        $this->middleware(['permission:carts.update'])->only(['update']);
        $this->middleware(['permission:carts.destroy'])->only(['destroy']);
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
            $carts = $this->cartRepository->getAll()->paginate();
            return $this->successResponse(new CartCollection($carts));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }




    public function viewUserCart($userId)
    {
        try {
            $cart = $this->cartRepository->getCartByUserId($userId);
            return $this->successResponse(new CartResource($cart));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }

    public function updateUserCart(UpdateUserCartRequest $request, $userId)
    {
        try {
            $data = $request->validated();
            $updated = $this->cartRepository->updateUserCart($userId, $data);

            if ($updated) {
                return $this->messageResponse(
                    __("cart::app.carts.updated-successfully"),
                    true,
                    200
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
