<?php

namespace Modules\Order\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Order\App\Http\Requests\Admin\Discount\ApplyDiscountRequest;
use Modules\Order\App\Repositories\DiscountRepository;
use Modules\Order\App\resources\Discount\DiscountResource;
use Modules\Order\App\Http\Requests\Admin\Discount\StoreDiscountRequest;
use Modules\Order\App\Http\Requests\Admin\Discount\UpdateDiscountRequest;
use Modules\Order\App\Repositories\OrderRepository;
use Modules\Order\App\resources\Discount\DiscountCollection;

class DiscountController extends Controller
{
    use ApiResponseTrait;
    protected $discountRepository;
    protected $orderRepository;
    protected $_config;
    protected $guard;
    public function __construct(DiscountRepository $discountRepository,OrderRepository $orderRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->discountRepository = $discountRepository;
        $this->orderRepository = $orderRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:discounts.show'])->only(['index', 'show']);
        $this->middleware(['permission:discounts.create'])->only(['store']);
        $this->middleware(['permission:discounts.update'])->only(['update']);
        $this->middleware(['permission:discounts.destroy'])->only(['destroy']);
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
            $data = $this->discountRepository->getAll()->paginate();
            return $this->successResponse(new DiscountCollection($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        try {
            $data =  $request->validated();
            $data['created_by'] = auth()->guard($this->guard)->id();
            $created = $this->discountRepository->createOne($data);

            if ($created) {
                return $this->messageResponse(
                    __("cart::app.discounts.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("cart::app.discounts.created-failed"),
                    false,
                    400
                );
            }
        } catch (Exception $e) {
            //    return  $this->messageResponse( $e->getMessage());
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
            $data = $this->discountRepository->findOrFail($id);
            return $this->successResponse(new DiscountResource($data));
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
    public function update(UpdateDiscountRequest $request, $id)
    {
        try {

            $data =  $request->validated();
            $data['updated_by'] = auth()->guard($this->guard)->id();
            $updated = $this->discountRepository->updateOne($data, $id);
            if ($updated) {
                return $this->messageResponse(
                    __("cart::app.discounts.updated-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("cart::app.discounts.updated-failed"),
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
            $deleted = $this->discountRepository->deleteOne($id);
            if ($deleted) {
                return $this->messageResponse(
                    __("cart::app.discounts.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("cart::app.discounts.deleted-failed"),
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
