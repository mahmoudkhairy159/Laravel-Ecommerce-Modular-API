<?php

namespace Modules\Order\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\App\Http\Requests\Admin\OrderHistory\StoreOrderHistoryRequest;
use Modules\Order\App\Http\Requests\Admin\OrderHistory\UpdateOrderHistoryRequest;
use Modules\Order\App\Repositories\OrderHistoryRepository;
use Modules\Order\App\Repositories\OrderRepository;
use Modules\Order\App\resources\OrderHistory\OrderHistoryCollection;
use Modules\Order\App\resources\OrderHistory\OrderHistoryResource;

class OrderHistoryController extends Controller
{
    use ApiResponseTrait;


    protected $orderHistoryRepository;
    protected $orderRepository;

    protected $_config;
    protected $guard;

    public function __construct(OrderHistoryRepository $orderHistoryRepository,OrderRepository $orderRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->orderHistoryRepository = $orderHistoryRepository;
        $this->orderRepository = $orderRepository;

        // permissions
        $this->middleware('auth:' . $this->guard);
    }
    /**
     * Display a listing of the resource.
     */
    public function getByOrderId($orderId)
    {
        try {
            $data = $this->orderRepository->getOneById($orderId);
            if (!$data) {
                return $this->messageResponse(
                    __('app.data-not-found'),
                    false,
                    404
                );
            }
            if($data->user_id != auth()->guard($this->guard)->id()){
                return $this->errorResponse(
                    [],
                    __('app.unauthorized'),
                    403
                );
            }
            $data = $this->orderHistoryRepository->getByOrderId($orderId)->paginate();
            return $this->successResponse(new OrderHistoryCollection($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [$e->getMessage(), $e->getCode()],
                __('app.something-went-wrong'),
                500
            );
        }
    }









}
