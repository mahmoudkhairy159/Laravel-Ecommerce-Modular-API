<?php

namespace Modules\Order\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\App\Http\Requests\Admin\OrderItem\StoreOrderItemRequest;
use Modules\Order\App\Http\Requests\Admin\OrderItem\UpdateOrderItemRequest;
use Modules\Order\App\Repositories\OrderItemRepository;
use Modules\Order\App\resources\OrderItem\OrderItemCollection;
use Modules\Order\App\resources\OrderItem\OrderItemResource;

class OrderItemController extends Controller
{
    use ApiResponseTrait;


    protected $orderItemRepository;

    protected $_config;
    protected $guard;

    public function __construct(OrderItemRepository $orderItemRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->orderItemRepository = $orderItemRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:orderItems.show'])->only(['getByOrderId', 'show']);
        $this->middleware(['permission:orderItems.create'])->only(['store']);
        $this->middleware(['permission:orderItems.update'])->only(['update']);
        $this->middleware(['permission:orderItems.destroy'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function getByOrderId($orderId)
    {
        try {
            $data = $this->orderItemRepository-> getByOrderId($orderId)->paginate();
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
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemRequest $request)
    {
        try {
            $data =  $request->validated();
            $created = $this->orderItemRepository->create($data);
            if ($created) {
                return $this->successResponse(
                    new OrderItemResource($created),
                    __('order::app.orderItems.created-successfully'),
                    201
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderItems.created-failed'),
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
            $data = $this->orderItemRepository->findOrFail($id);
            return $this->successResponse(new OrderItemResource($data));
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
    public function update(UpdateOrderItemRequest $request, $id)
    {
        try {
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
