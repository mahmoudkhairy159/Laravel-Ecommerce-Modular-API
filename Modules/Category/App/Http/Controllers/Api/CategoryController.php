<?php

namespace Modules\Category\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Category\App\Repositories\CategoryRepository;
use Modules\Category\App\resources\Category\CategoryCollection;
use Modules\Category\App\resources\Category\CategoryResource;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    protected $categoryRepository;
    protected $_config;
    protected $guard;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->categoryRepository = $categoryRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);

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




}
