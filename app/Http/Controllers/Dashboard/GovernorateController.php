<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Governorate\GovernorateRequest;
use App\Http\Requests\Dashboard\ShippingGovernorates\ShippingGovernoratesRequest;

class GovernorateController extends Controller
{
    public function __construct(public Governorate $model){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->model->paginate();
        return view('admin.governorates.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();

        return view('admin.governorates.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GovernorateRequest $request)
    {
       $data = $request->validated();

        $this->model->create($data);

        return redirect()->route('Admin.governorates.index')->with('success','Created governorate');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $governorate = $this->model->findOrFail($id);
        return view('admin.governorates.show',compact('governorate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $governorate = $this->model->findOrFail($id);
        $countries = Country::all();
        return view('admin.governorates.edit',compact('governorate','countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GovernorateRequest $request, string $id)
    {
        $data = $request->validated();
        $governorate = $this->model->findOrFail($id);
        $governorate->update($data);
        return redirect()->route('Admin.governorates.index')->with('success','Updated governorate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $governorate = $this->model->findOrFail($id);
        $governorate->delete();
        return redirect()->route('Admin.governorates.index')->with('success','Deleted governorate');

    }
}
