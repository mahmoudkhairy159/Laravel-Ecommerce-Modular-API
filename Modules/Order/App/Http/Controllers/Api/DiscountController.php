<?php

namespace Modules\Order\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\App\Http\Requests\Api\Discount\ApplyDiscountRequest;
use Modules\Order\App\Repositories\OrderRepository;

class DiscountController extends Controller
{
    use ApiResponseTrait;
    protected $orderRepository;
    protected $_config;
    protected $guard;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->orderRepository = $orderRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
    }



    public function applyDiscount(ApplyDiscountRequest $request)
    {
        try {
            $data = $request->validated();
            $applied=$this->orderRepository->applyDiscount($data);

            if ($applied) {
                return $this->messageResponse(
                    __("order::app.discounts.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("order::app.discounts.created-failed"),
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
