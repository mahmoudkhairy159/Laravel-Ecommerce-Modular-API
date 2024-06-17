<?php

namespace Modules\Payment\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Payment\App\Http\Requests\Api\UserPayment\StoreUserPaymentRequest;
use Modules\Payment\App\Http\Requests\Api\UserPayment\UpdateUserPaymentRequest;
use Modules\Payment\App\Models\UserPayment;
use Modules\Payment\App\Repositories\UserPaymentRepository;
use Modules\Payment\App\resources\UserPayment\UserPaymentResource;
use Modules\Payment\App\resources\UserPayment\UserPaymentCollection;

class UserPaymentController extends Controller
{
    use ApiResponseTrait;


    protected $userPaymentRepository;

    protected $_config;
    protected $guard;

    public function __construct(UserPaymentRepository $userPaymentRepository,)
    {
        $this->guard = 'user-api';
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->userPaymentRepository = $userPaymentRepository;
        $this->middleware('auth:' . $this->guard);

    }



    public function getMyPayments()
    {
        try {
            $user_id=Auth::guard($this->guard)->id();
            $data = $this->userPaymentRepository->getActiveByUserId($user_id)->paginate();
            return $this->successResponse(new UserPaymentCollection($data));
        } catch (Exception $e) {

            return $this->errorResponse(
                [$e->getMessage()],
                __('app.something-went-wrong'),
                500
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserPaymentRequest $request)
    {
        try {
            $data =  $request->validated();
            $data['user_id'] = auth()->guard($this->guard)->id();
            $created = $this->userPaymentRepository->create($data);
            if ($created) {
                return $this->messageResponse(
                    __("payment::app.userPayments.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("payment::app.userPayments.created-failed"),
                    false,
                    400
                );
            }
        } catch (Exception $e) {
            return $this->errorResponse(
                [$e->getMessage()],
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
            $userPayment = $this->userPaymentRepository->where('status',UserPayment::STATUS_ACTIVE)->findOrFail($id);
            $data = new UserPaymentResource($userPayment);
            return $this->successResponse($data);
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
    public function update(UpdateUserPaymentRequest $request, $id)
    {
        try {

            $data =  $request->validated();
            $data['user_id'] = auth()->guard($this->guard)->id();
            $updated = $this->userPaymentRepository->update($data, $id);

            if ($updated) {
                return $this->messageResponse(
                    __("payment::app.userPayments.updated-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("payment::app.userPayments.updated-failed"),
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

            $deleted = $this->userPaymentRepository->changePaymentActivity($id);
            if ($deleted) {
                return $this->messageResponse(
                    __("payment::app.userPayments.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("payment::app.userPayments.deleted-failed"),
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
