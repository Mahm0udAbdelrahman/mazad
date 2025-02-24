<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\MaintenanceCenter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\MaintenanceCenter\MaintenanceCenterRequest;

class MaintenanceCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public MaintenanceCenter $model){}
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $data = $this->model->paginate();
            return view('admin.maintenance_centers.index',compact('data'));
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return view('admin.maintenance_centers.create');
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(MaintenanceCenterRequest $request)
        {
           $data = $request->validated();

            $this->model->create($data);

            return redirect()->route('Admin.maintenance_centers.index')->with('success','Created maintenance_center');

        }

        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            $maintenance_center = $this->model->findOrFail($id);
            return view('admin.maintenance_centers.show',compact('maintenance_center'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            $maintenance_center = $this->model->findOrFail($id);
            return view('admin.maintenance_centers.edit',compact('maintenance_center'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(MaintenanceCenterRequest $request, string $id)
        {
            $data = $request->validated();
            $maintenance_center = $this->model->findOrFail($id);

            $maintenance_center->update($data);

             return redirect()->route('Admin.maintenance_centers.index')->with('success','Updated maintenance_center');

        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $maintenance_center = $this->model->findOrFail($id);
            $maintenance_center->delete();
            return redirect()->route('Admin.maintenance_centers.index')->with('success','Deleted maintenance_center');

        }
}
