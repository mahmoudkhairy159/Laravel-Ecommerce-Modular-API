<?php

namespace Modules\Area\App\Http\Controllers\Api;

use Exception;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Area\App\Repositories\CityRepository;
use Modules\Area\App\resources\City\CityResource;
use Modules\Area\App\Http\Requests\Admin\City\StoreCityRequest;
use Modules\Area\App\Http\Requests\Admin\City\UpdateCityRequest;
use Modules\Area\App\Models\City;
use Modules\Area\App\resources\City\CityCollection;

class CityController extends Controller
{
    use ApiResponseTrait;


    protected $cityRepository;

    protected $_config;
    protected $guard;

    public function __construct(CityRepository $cityRepository)
    {
        $this->guard = 'user-api';
        request()->merge(['token' => 'true']);
        Auth::setDefaultDriver($this->guard);
        $this->_config = request('_config');
        $this->cityRepository = $cityRepository;
        // permissions
        $this->middleware('auth:' . $this->guard);
    }


    public function getByCountryId($country_id)
    {
        try {
            $data = $this->cityRepository->getActiveCitiesByCountryId($country_id)->get();
            return $this->successResponse(CityResource::collection($data));
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
            $data = $this->cityRepository->findOrFail($id);
            return $this->successResponse(new CityResource($data));
        } catch (Exception $e) {
            return $this->errorResponse(
                [],
                __('app.something-went-wrong'),
                500
            );
        }
    }
}
