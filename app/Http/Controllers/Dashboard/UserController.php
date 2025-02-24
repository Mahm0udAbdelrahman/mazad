<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\HasImage;
use Illuminate\Http\Request;
use App\Helpers\HandleUpload;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\{User,ModelHasRole};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Hash,Session};
use App\Http\Requests\Dashboard\User\{StoreUserRequest,UpdateUserRequest,ProfileRequest};

class UserController extends Controller
{
    use HasImage;
    public function index(Request $request)
    {
               $users = User::latest()->paginate(10);
        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
      
        $roles = Role::select(['id','name'])->get();
        return view('admin.users.create',compact('roles'));
    }

    public function store(StoreUserRequest $storeUserRequest)
    {
      
        $data = $storeUserRequest->validated();
        $data['password'] = Hash::make($storeUserRequest->password);

        $user = User::create($data);
        DB::table('model_has_roles')->insert([
            'model_type' => 'App\\Models\\User',
            'model_id' => $user->id,
            'role_id' => $storeUserRequest->role_id
        ]);

        Session::flash('message', ['type' => 'success', 'text' => __('User created successfully')]);
        return redirect()->route('Admin.users.index');
    }

    public function edit(User $user)
    {
      
        $roles = Role::select(['id','name'])->get();
        return view('admin.users.edit',compact('user','roles'));
    }

    public function update(UpdateUserRequest $updateUserRequest,User $user)
    {
      
        $data = $updateUserRequest->validated();
        $data['password'] = $updateUserRequest->password ? Hash::make($updateUserRequest->password) : $user->password;

        $user->update($data);
        $criteria = [ 'model_id' => $user->id];
        $attributes = [
            'model_type' => 'App\\Models\\User',
            'model_id' => $user->id,
            'role_id' => $updateUserRequest->role_id
        ];
        DB::table('model_has_roles')->updateOrInsert($criteria, $attributes);


        Session::flash('message', ['type' => 'success', 'text' => __('User updated successfully')]);
        return redirect()->route('Admin.users.index');
    }

    public function profile()
    {
        return view('admin.users.profile');
    }

    public function updateProfile(ProfileRequest $profileRequest)
    {
        $user = User::where('id',auth()->user()->id)->first();

        $data = $profileRequest->validated();
        $data['password'] = $profileRequest->password ? Hash::make($profileRequest->password) : $user->password;
        $data['image'] = $profileRequest->hasFile('image') ? $this->saveImage($profileRequest->image , 'users/images') : $user->image;
        $user->update($data);

        Session::flash('message', ['type' => 'success', 'text' => __('User updated successfully')]);
        return redirect()->back();
    }
}
