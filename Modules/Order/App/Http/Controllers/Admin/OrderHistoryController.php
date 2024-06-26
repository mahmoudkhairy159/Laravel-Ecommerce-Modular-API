<?php

namespace Modules\Order\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\App\Http\Requests\Admin\OrderHistory\StoreOrderHistoryRequest;
use Modules\Order\App\Http\Requests\Admin\OrderHistory\UpdateOrderHistoryRequest;
use Modules\Order\App\Repositories\OrderHistoryRepository;
use Modules\Order\App\resources\OrderHistory\OrderHistoryCollection;
use Modules\Order\App\resources\OrderHistory\OrderHistoryResource;

class OrderHistoryController extends Controller
{
    use ApiResponseTrait;


    protected $orderHistoryRepository;

    protected $_config;
    protected $guard;

    public function __construct(OrderHistoryRepository $orderHistoryRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->orderHistoryRepository = $orderHistoryRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:orderHistories.show'])->only(['getByOrderId', 'show']);
        $this->middleware(['permission:orderHistories.create'])->only(['store']);
        $this->middleware(['permission:orderHistories.update'])->only(['update']);
        $this->middleware(['permission:orderHistories.destroy'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function getByOrderId($orderId)
    {
        try {
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




    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderHistoryRequest $request)
    {
        try {
            $data =  $request->validated();
            $created = $this->orderHistoryRepository->create($data);
            if ($created) {
                return $this->successResponse(
                    new OrderHistoryResource($created),
                    __('order::app.orderHistories.created-successfully'),
                    201
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderHistories.created-failed'),
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
            $data = $this->orderHistoryRepository->findOrFail($id);
            return $this->successResponse(new OrderHistoryResource($data));
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
    public function update(UpdateOrderHistoryRequest $request, $id)
    {
        try {
            $data =  $request->validated();
            $updated = $this->orderHistoryRepository->update($data, $id);

            if ($updated) {
                return $this->successResponse(
                    new OrderHistoryResource($updated),
                    __('order::app.orderHistories.updated-successfully'),
                    200
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderHistories.updated-failed'),
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

            $deleted = $this->orderHistoryRepository->delete($id);

            if ($deleted) {
                return $this->messageResponse(
                    __('order::app.orderHistories.deleted-successfully'),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderHistories.deleted-failed'),
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
