<?php

namespace Modules\Order\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\App\Http\Requests\Admin\OrderShippingInformation\StoreOrderShippingInformationRequest;
use Modules\Order\App\Http\Requests\Admin\OrderShippingInformation\UpdateOrderShippingInformationRequest;
use Modules\Order\App\Repositories\OrderShippingInformationRepository;
use Modules\Order\App\resources\OrderShippingInformation\OrderShippingInformationCollection;
use Modules\Order\App\resources\OrderShippingInformation\OrderShippingInformationResource;

class OrderShippingInformationController extends Controller
{
    use ApiResponseTrait;


    protected $orderShippingInformationRepository;

    protected $_config;
    protected $guard;

    public function __construct(OrderShippingInformationRepository $orderShippingInformationRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->orderShippingInformationRepository = $orderShippingInformationRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:orderShippingInformation.show'])->only(['getByOrderId', 'show']);
        $this->middleware(['permission:orderShippingInformation.create'])->only(['store']);
        $this->middleware(['permission:orderShippingInformation.update'])->only(['update']);
        $this->middleware(['permission:orderShippingInformation.destroy'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function getByOrderId($orderId)
    {
        try {
            $data = $this->orderShippingInformationRepository->getByOrderId($orderId)->first();
            return $this->successResponse(new OrderShippingInformationResource($data));
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
    public function store(StoreOrderShippingInformationRequest $request)
    {
        try {
            $data =  $request->validated();
            $created = $this->orderShippingInformationRepository->create($data);
            if ($created) {
                return $this->successResponse(
                    new OrderShippingInformationResource($created),
                    __('order::app.orderShippingInformation.created-successfully'),
                    201
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderShippingInformation.created-failed'),
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
            $data = $this->orderShippingInformationRepository->findOrFail($id);
            return $this->successResponse(new OrderShippingInformationResource($data));
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
    public function update(UpdateOrderShippingInformationRequest $request, $id)
    {
        try {
            $data =  $request->validated();
            $updated = $this->orderShippingInformationRepository->update($data, $id);

            if ($updated) {
                return $this->successResponse(
                    new OrderShippingInformationResource($updated),
                    __('order::app.orderShippingInformation.updated-successfully'),
                    200
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderShippingInformation.updated-failed'),
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

            $deleted = $this->orderShippingInformationRepository->delete($id);

            if ($deleted) {
                return $this->messageResponse(
                    __('order::app.orderShippingInformation.deleted-successfully'),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __('order::app.orderShippingInformation.deleted-failed'),
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
