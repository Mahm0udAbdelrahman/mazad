<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\{DB,Session};
use App\Http\Requests\Dashboard\Role\{RoleRequest,UpdateRoleRequest,PermissionRequest};

class RoleController extends Controller
{
    public function index(Request $request)
    {
        // $this->authorize('roles-عرض');
        $roles = Role::paginate(10);
        return view('admin.roles.index',compact('roles'));
    }

    public function create()
    {
        // $this->authorize('roles-اضافة');
        $permissions = Permission::all();
        // dd($permissions);
        return view('admin.roles.create',compact('permissions'));
    }

    public function store(RoleRequest $request, PermissionRequest $permissionRequest)
    {
        // $this->authorize('roles-اضافة');
        if ($request->select_all) {
            $permissions = json_decode($request->select_all);
        } else {
            $permissions = $permissionRequest->permission_name;
        }

        $role = Role::create($request->validated());
        $role->syncPermissions($permissions);

        Session::flash('message', ['type' => 'success', 'text' => __('Role created successfully')]);
        return redirect()->route('Admin.roles.index');
    }

    public function edit(Role $role)
    {
        // $this->authorize('roles-تعديل');
        $ids = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::all();
        $permissionNum = $role->permissions->count();
        return view('admin.roles.edit', compact('role','permissions','permissionNum','ids'));
    }

    public function update(UpdateRoleRequest $request,PermissionRequest $req, Role $role)
    {
        // $this->authorize('roles-تعديل');

        if ($request->select_all) {
            $permissions = json_decode($request->select_all);
        } else {
            $permissions = $req->permission_name;
        }
        $role->update(['name' => $request->name]);
        $role->syncPermissions($permissions);

        Session::flash('message', ['type' => 'success', 'text' => __('Role updated successfully')]);
        return redirect()->route('Admin.roles.index');
    }
}
