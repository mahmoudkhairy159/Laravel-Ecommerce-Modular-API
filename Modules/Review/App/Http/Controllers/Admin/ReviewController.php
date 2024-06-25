<?php

namespace Modules\Review\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Review\App\Repositories\ReviewRepository;
use Modules\Review\App\resources\Review\ReviewCollection;
use Modules\Review\App\resources\Review\ReviewResource;

class ReviewController extends Controller
{
    use ApiResponseTrait;


    protected $reviewRepository;

    protected $_config;
    protected $guard;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->reviewRepository = $reviewRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:reviews.show'])->only(['index', 'show', 'getByItemId', 'getByUserId']);
        $this->middleware(['permission:reviews.destroy'])->only(['destroy','forceDelete', 'restore', 'getOnlyTrashed']);
    }


    public function getByItemId($item_id)
    {
        try {
            $data = $this->reviewRepository->getByItemId($item_id)->paginate();
            return $this->successResponse(new ReviewCollection($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }
    public function getByUserId($user_id)
    {
        try {
            $data = $this->reviewRepository->getByUserId($user_id)->paginate();
            return $this->successResponse(new ReviewCollection($data));
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
            $data = $this->reviewRepository->findOrFail($id);
            return $this->successResponse(new ReviewResource($data));
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
            $review = $this->reviewRepository->findOrFail($id);
            $deleted = $this->reviewRepository->delete($id);
            if ($deleted) {
                return $this->messageResponse(
                    __("review::app.reviews.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("review::app.reviews.deleted-failed"),
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
        /***********Trashed model SoftDeletes**************/
        public function getOnlyTrashed()
        {
            try {
                $data = $this->reviewRepository->getOnlyTrashed()->paginate();
                return $this->successResponse(new ReviewCollection($data));
            } catch (Exception $e) {
                return $this->errorResponse(
                    [],
                    __('app.something-went-wrong'),
                    500
                );
            }
        }

        public function forceDelete($id)
        {
            try {
                $deleted = $this->reviewRepository->forceDelete($id);
                if ($deleted) {
                    return $this->messageResponse(
                        __("review::app.reviews.deleted-successfully"),
                        true,
                        200
                    );
                } {
                    return $this->messageResponse(
                        __("review::app.reviews.deleted-failed"),
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

        public function restore($id)
        {
            try {
                $restored = $this->reviewRepository->restore($id);
                if ($restored) {
                    return $this->messageResponse(
                        __("review::app.reviews.restored-successfully"),
                        true,
                        200
                    );
                } {
                    return $this->messageResponse(
                        __("review::app.reviews.restored-failed"),
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
        /***********Trashed model SoftDeletes**************/
}
