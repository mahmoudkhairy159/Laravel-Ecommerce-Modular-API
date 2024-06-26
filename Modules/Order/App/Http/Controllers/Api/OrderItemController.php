<?php

namespace Modules\Order\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\App\Http\Requests\Api\OrderItem\UpdateOrderItemRequest;
use Modules\Order\App\Repositories\OrderItemRepository;
use Modules\Order\App\Repositories\OrderRepository;
use Modules\Order\App\resources\OrderItem\OrderItemCollection;
use Modules\Order\App\resources\OrderItem\OrderItemResource;

class OrderItemController extends Controller
{
    use ApiResponseTrait;


    protected $orderItemRepository;
    protected $orderRepository;

    protected $_config;
    protected $guard;

    public function __construct(OrderItemRepository $orderItemRepository,OrderRepository $orderRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->orderItemRepository = $orderItemRepository;
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
            $data = $this->orderItemRepository->getByOrderId($orderId)->paginate();
            return $this->successResponse(new OrderItemCollection($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [$e->getMessage(), $e->getCode()],
                __('app.something-went-wrong'),
                500
            );
        }
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, $id)
    {
        try {
            $data = $this->orderItemRepository->where('user_id', auth()->guard($this->guard)->id())->findOrFail($id);
            $data =  $request->validated();
            $updated = $this->orderItemRepository->update($data, $id);

            if ($updated) {
                return $this->successResponse(
                    new OrderItemResource($updated),
                    __('order::app.orderItems.updated-successfully'),
                    200
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderItems.updated-failed'),
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
            $data = $this->orderItemRepository->where('user_id', auth()->guard($this->guard)->id())->findOrFail($id);
            $deleted = $this->orderItemRepository->delete($id);
            if ($deleted) {
                return $this->messageResponse(
                    __('order::app.orderItems.deleted-successfully'),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderItems.deleted-failed'),
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










