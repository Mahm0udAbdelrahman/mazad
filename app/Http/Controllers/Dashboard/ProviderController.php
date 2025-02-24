<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Helpers\HandleUpload;
use App\Models\AccountProvider;
use App\Models\TransationHestory;
use App\Http\Controllers\Controller;
use App\Models\{User, Role, ModelHasRole};
use Illuminate\Support\Facades\{Hash, Session};
use App\Http\Requests\Dashboard\Provider\StoreProviderRequest;
use App\Http\Requests\Dashboard\Provider\UpdateProviderRequest;
use App\Http\Requests\Dashboard\User\{StoreUserRequest, UpdateUserRequest, ProfileRequest};

class ProviderController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('providers-عرض');
        $providers = User::select(['id', 'name', 'email', 'phone'])->where('type', '=', '2')->orderBy('id', 'desc')->paginate(10);
        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        $this->authorize('providers-اضافة');
        $roles = Role::select(['id', 'name'])->get();
        return view('admin.providers.create', compact('roles'));
    }

    public function store(StoreProviderRequest $storeProviderRequest)
    {
        $this->authorize('providers-اضافة');
        $data = $storeProviderRequest->validated();
        $data['password'] = Hash::make($storeProviderRequest->password);
        $data['type'] = 2;
        $provider = User::create($data);


        Session::flash('message', ['type' => 'success', 'text' => __('Provider created successfully')]);
        return redirect()->route('Admin.providers.index');
    }


    public function show($id)
    {
        $provider = User::findOrFail($id);
        $this->authorize('providers-قراءة');
        $balance = AccountProvider::where('provider_id',$provider->id)->value('balance');
        $transaction_histories = TransationHestory::where('provider_id',$provider->id)->where('status','complete')->orderBy('created_at','desc')->get();
        return view('admin.providers.show', compact('provider', 'balance','transaction_histories'));
    }

    public function edit($id)
    {
        $provider = User::findOrFail($id);
        $this->authorize('providers-تعديل');
        $roles = Role::select(['id', 'name'])->get();
        return view('admin.providers.edit', compact('provider', 'roles'));
    }

    public function update(UpdateProviderRequest $UpdateProviderRequest, User $provider)
    {
        $this->authorize('providers-تعديل');
        $data = $UpdateProviderRequest->validated();
        $data['password'] = $UpdateProviderRequest->password ? Hash::make($UpdateProviderRequest->password) : $provider->password;
        $data['type'] = 2;
        $provider->update($data);



        Session::flash('message', ['type' => 'success', 'text' => __('Provider updated successfully')]);
        return redirect()->route('Admin.providers.index');
    }

    public function profile()
    {
        return view('admin.users.profile');
    }

    public function updateProfile(ProfileRequest $profileRequest)
    {
        $provider = User::where('id', auth()->user()->id)->first();

        $data = $profileRequest->validated();
        $data['password'] = $profileRequest->password ? Hash::make($profileRequest->password) : $provider->password;
        $data['image'] = $profileRequest->hasFile('image') ? HandleUpload::uploadFile($profileRequest->image, 'users/images') : $provider->image;
        $provider->update($data);

        Session::flash('message', ['type' => 'success', 'text' => __('Provider updated successfully')]);
        return redirect()->back();
    }
    public function destroy($id)
    {
        $provider = User::findOrFail($id);

        if ($provider) {
            $provider->delete();
            return response()->json(['success' => true, 'message' => 'تم حذف المورد بنجاح']);
        }

        return response()->json(['success' => false, 'message' => 'لم يتم العثور على المورد'], 404);
    }

}
