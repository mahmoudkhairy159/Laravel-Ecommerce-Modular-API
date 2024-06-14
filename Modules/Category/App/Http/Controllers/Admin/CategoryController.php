<?php

namespace Modules\Category\App\Http\Controllers\Admin;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Category\App\Repositories\CategoryRepository;
use Modules\Category\App\resources\Category\CategoryResource;
use Modules\Category\App\Http\Requests\Admin\Category\StoreCategoryRequest;
use Modules\Category\App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Modules\Category\App\resources\Category\CategoryCollection;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    protected $categoryRepository;
    protected $_config;
    protected $guard;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->guard = 'admin-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->categoryRepository = $categoryRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
        $this->middleware(['permission:categories.show'])->only(['index', 'show']);
        $this->middleware(['permission:categories.create'])->only(['store']);
        $this->middleware(['permission:categories.update'])->only(['update']);
        $this->middleware(['permission:categories.destroy'])->only(['destroy','forceDelete', 'restore', 'getOnlyTrashed']);
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
            $data = $this->categoryRepository->getAll()->paginate();
            return $this->successResponse(new CategoryCollection($data));
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
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data =  $request->validated();
            $data['created_by'] = auth()->guard($this->guard)->id();
            $created = $this->categoryRepository->createOne($data);

            if ($created) {
                return $this->messageResponse(
                    __("category::app.categories.created-successfully"),
                    true,
                    201
                );
            } {
                return $this->messageResponse(
                    __("category::app.categories.created-failed"),
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
            $data = $this->categoryRepository->findOrFail($id);
            return $this->successResponse(new CategoryResource($data));
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
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {

            $data =  $request->validated();
            $data['updated_by'] = auth()->guard($this->guard)->id();
            $updated = $this->categoryRepository->updateOne($data, $id);
            if ($updated) {
                return $this->messageResponse(
                    __("category::app.categories.updated-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("category::app.categories.updated-failed"),
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
            $deleted = $this->categoryRepository->deleteOne($id);
            if ($deleted) {
                return $this->messageResponse(
                    __("category::app.categories.deleted-successfully"),
                    true,
                    200
                );
            } {
                return $this->messageResponse(
                    __("category::app.categories.deleted-failed"),
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
             $data = $this->categoryRepository->getOnlyTrashed()->paginate();
             return $this->successResponse(new CategoryCollection($data));
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
             $deleted = $this->categoryRepository->forceDelete($id);
             if ($deleted) {
                 return $this->messageResponse(
                     __("category::app.categories.deleted-successfully"),
                     true,
                     200
                 );
             } {
                 return $this->messageResponse(
                     __("category::app.categories.deleted-failed"),
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
             $restored = $this->categoryRepository->restore($id);
             if ($restored) {
                 return $this->messageResponse(
                     __("category::app.categories.restored-successfully"),
                     true,
                     200
                 );
             } {
                 return $this->messageResponse(
                     __("category::app.categories.restored-failed"),
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
