<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Country\CountryRequest;

class CountryController extends Controller
{
    public function __construct(public Country $model){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = $this->model->paginate();
        return view('admin.countries.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryRequest $request)
    {
       $data = $request->validated();

        $this->model->create($data);

        return redirect()->route('Admin.countries.index')->with('success','Created country');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $country = $this->model->findOrFail($id);
        return view('admin.countries.show',compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = $this->model->findOrFail($id);
        return view('admin.countries.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CountryRequest $request, string $id)
    {
        $data = $request->validated();
        $country = $this->model->findOrFail($id);

        $country->update($data);

         return redirect()->route('Admin.countries.index')->with('success','Updated country');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = $this->model->findOrFail($id);
        $country->delete();
        return redirect()->route('Admin.countries.index')->with('success','Deleted country');

    }
}
