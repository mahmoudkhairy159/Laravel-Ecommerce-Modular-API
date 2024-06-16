<?php

namespace Modules\Brand\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Brand\App\Repositories\BrandRepository;
use Modules\Brand\App\resources\Brand\BrandCollection;
use Modules\Brand\App\resources\Brand\BrandResource;

class BrandController extends Controller
{
    use ApiResponseTrait;
    protected $brandRepository;
    protected $_config;
    protected $guard;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->brandRepository = $brandRepository;
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




}
