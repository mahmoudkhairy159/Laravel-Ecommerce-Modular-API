<?php

namespace Modules\Brand\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Brand\App\Repositories\BrandRepository;
use Modules\Brand\App\resources\Brand\BrandResource;
use Modules\Brand\App\Http\Requests\Admin\Brand\StoreBrandRequest;
use Modules\Brand\App\Http\Requests\Admin\Brand\UpdateBrandRequest;
use Modules\Brand\App\resources\Brand\BrandCollection;

class BrandController extends Controller
{
    use ApiResponseTrait;
    protected $brandRepository;
    protected $_config;
    protected $guard;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->brandRepository = $brandRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:brands.show'])->only(['index', 'show']);
        $this->middleware(['permission:brands.create'])->only(['store']);
        $this->middleware(['permission:brands.update'])->only(['update']);
        $this->middleware(['permission:brands.destroy'])->only(['destroy','forceDelete', 'restore', 'getOnlyTrashed']);
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
            $data = $this->brandRepository->getAll()->paginate();
            return $this->successResponse(new BrandCollection($data));
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
    public function store(StoreBrandRequest $request)
    {
        try {
            $data =  $request->validated();
            $data['created_by'] = auth()->guard($this->guard)->id();
            $created = $this->brandRepository->createOne($data);

            if ($created) {
                return $this->messageResponse(
                    __("brand::app.brands.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("brand::app.brands.created-failed"),
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
            $data = $this->brandRepository->findOrFail($id);
            return $this->successResponse(new BrandResource($data));
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
    public function update(UpdateBrandRequest $request, $id)
    {
        try {

            $data =  $request->validated();
            $data['updated_by'] = auth()->guard($this->guard)->id();
            $updated = $this->brandRepository->updateOne($data, $id);
            if ($updated) {
                return $this->messageResponse(
                    __("brand::app.brands.updated-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("brand::app.brands.updated-failed"),
                    false,
                    400
                );
            }
        } catch (Exception $e) {
            // return  $this->messageResponse( $e->getMessage());

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
            $deleted = $this->brandRepository->deleteOne($id);
            if ($deleted) {
                return $this->messageResponse(
                    __("brand::app.brands.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("brand::app.brands.deleted-failed"),
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
             $data = $this->brandRepository->getOnlyTrashed()->paginate();
             return $this->successResponse(new BrandCollection($data));
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
             $deleted = $this->brandRepository->forceDelete($id);
             if ($deleted) {
                 return $this->messageResponse(
                     __("brand::app.brands.deleted-successfully"),
                     true,
                     200
                 );
             } {
                 return $this->messageResponse(
                     __("brand::app.brands.deleted-failed"),
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
             $restored = $this->brandRepository->restore($id);
             if ($restored) {
                 return $this->messageResponse(
                     __("brand::app.brands.restored-successfully"),
                     true,
                     200
                 );
             } {
                 return $this->messageResponse(
                     __("brand::app.brands.restored-failed"),
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
