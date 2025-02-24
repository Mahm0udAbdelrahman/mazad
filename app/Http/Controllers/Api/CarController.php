<?php

namespace App\Http\Controllers\Api;

use App\Services\CarService;
use App\Traits\HttpResponse;
use App\Http\Resources\CarResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Car\CarRequest;
use App\Http\Requests\Api\Car\CarUpdateRequest;
use Illuminate\Http\Request;
class CarController extends Controller
{
    use   HttpResponse;
    public function __construct(public CarService $carService){}
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $cars = $this->carService->index();
        return $this->paginatedResponse($cars, CarResource::class);
    }

    public function filter(Request $request){
        $filters = $request->all();
        $cars = $this->carService->filterCars($filters);
        return $cars;

    }

    public function getCarStatusPending()
    {
        $cars = $this->carService->getCarStatusPending();
        return $this->paginatedResponse($cars, CarResource::class);

    }

    public function getCarStatusApproved()
    {
        $cars = $this->carService->getCarStatusApproved();
        return $this->paginatedResponse($cars, CarResource::class);
    }

    public function getCarStatusRejected()
    {
        $cars = $this->carService->getCarStatusRejected();
        return $this->paginatedResponse($cars, CarResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
        $newCar = $this->carService->store($request->validated());
       return $this->okResponse(new CarResource($newCar), __('The car has been added successfully', [], request()->header('Accept-language')));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car =  $this->carService->show($id);

        return $this->okResponse(new CarResource($car), __('The car has been  successfully', [], request()->header('Accept-language')));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarUpdateRequest $request, string $id)
    {
        $car =   $this->carService->update($id, $request->validated());

        return $this->okResponse(new CarResource($car), __('The car has been updated successfully', [], request()->header('Accept-language')));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car =  $this->carService->destroy($id);
        return $this->okResponse( message: __('The car has been deleted successfully', [], request()->header('Accept-language')));

    }
}
