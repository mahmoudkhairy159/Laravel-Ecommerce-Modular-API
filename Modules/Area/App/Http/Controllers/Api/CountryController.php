<?php

namespace Modules\Area\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Area\App\Repositories\CountryRepository;
use Modules\Area\App\resources\Country\CountryResource;

use Modules\Area\App\Models\Country;

class CountryController extends Controller
{
    use ApiResponseTrait;


    protected $countryRepository;

    protected $_config;
    protected $guard;

    public function __construct(CountryRepository $countryRepository)
    {


        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->countryRepository = $countryRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->countryRepository->getAllActive()->get();
            return $this->successResponse(CountryResource::collection($data));
        } catch (Exception $e) {
            dd($e->getMessage());
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
            $data = $this->countryRepository->find($id);
            return $this->successResponse(new CountryResource($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }



}
