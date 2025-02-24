@extends('admin.layout')
@section('title', __('Edit User'))

@section('content')
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-10 offset-xl-1">
                <form method="post" action="{{ route('Admin.users.update', $user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm rounded-4">
                        <div class="card-header bg-primary text-white rounded-top-4">
                            <h5 class="mb-0">{{ __('Modify User Data') }}</h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-4">

                                <!-- Name -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Enter the user name') }}" value="{{ old('name', $user->name) }}">
                                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Enter the user email') }}" value="{{ old('email', $user->email) }}">
                                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-md-6">
                                    <label for="address" class="form-label">{{ __('Address') }}</label>
                                    <input type="text" name="address" id="address" class="form-control" placeholder="{{ __('Enter the user address') }}" value="{{ old('address', $user->address) }}">
                                    @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Image -->
                                <div class="col-md-6">
                                    <label for="image" class="form-label">{{ __('Image') }}</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    @if ($user->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="rounded shadow" width="100">
                                        </div>
                                    @endif
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="{{ __('Enter the user mobile number') }}" value="{{ old('phone', $user->phone) }}">
                                    @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- National Number -->
                                <div class="col-md-6">
                                    <label for="national_number" class="form-label">{{ __('National Number') }}</label>
                                    <input type="text" name="national_number" id="national_number" class="form-control" placeholder="{{ __('Enter the user national number') }}" value="{{ old('national_number', $user->national_number) }}">
                                    @error('national_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Service -->
                                <div class="col-md-6">
                                    <label for="service" class="form-label">{{ __('Service') }}</label>
                                    <select class="form-select" name="service" id="service">
                                        <option disabled>{{ __('Choose Service...') }}</option>
                                        <option value="vendor" {{ old('service', $user->service) === 'vendor' ? 'selected' : '' }}>{{ __('Vendor') }}</option>
                                        <option value="merchant" {{ old('service', $user->service) === 'merchant' ? 'selected' : '' }}>{{ __('Merchant') }}</option>
                                    </select>
                                    @error('service') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <label for="category" class="form-label">{{ __('Category') }}</label>
                                    <select class="form-select" name="category" id="category">
                                        <option disabled>{{ __('Choose Category...') }}</option>
                                        <option value="my" {{ old('category', $user->category) === 'my' ? 'selected' : '' }}>{{ __('My') }}</option>
                                        <option value="dealer" {{ old('category', $user->category) === 'dealer' ? 'selected' : '' }}>{{ __('Dealer') }}</option>
                                    </select>
                                    @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter the user password') }}">
                                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <!-- Role -->
                                <div class="col-md-6">
                                    <label for="role_id" class="form-label">{{ __('Role') }}</label>
                                    <select class="form-select" name="role_id" id="role_id">
                                        <option disabled>{{ __('Choose the user role') }}</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-success px-4">{{ __('Save Changes') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
