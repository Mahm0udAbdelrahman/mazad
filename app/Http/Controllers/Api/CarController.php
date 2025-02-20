<?php

namespace App\Http\Controllers\Api;

use App\Service\CarService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Car\CarRequest;
use App\Http\Requests\Api\Car\CarUpdateRequest;

class CarController extends Controller
{
    public function __construct(public CarService $carService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  $this->carService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
       return  $this->carService->store($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return  $this->carService->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarUpdateRequest $request, string $id)
    {
        return  $this->carService->update($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return  $this->carService->destroy($id);
    }
}
