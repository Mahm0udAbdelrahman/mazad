@extends('admin.layout')
@section('title', __('Edit Maintenance Center'))

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <form method="post" action="{{ route('Admin.maintenance_centers.update', $maintenance_center->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6>{{ __('Edit Maintenance Center') }}</h6>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="name_ar" value="{{ $maintenance_center->name_ar }}" class="form-control" placeholder="{{ __('Enter Name Arabic') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="address_ar" value="{{ $maintenance_center->address_ar }}" class="form-control" placeholder="{{ __('Enter Address Arabic') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="name_en" value="{{ $maintenance_center->name_en }}" class="form-control" placeholder="{{ __('Enter Name English') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="address_en" value="{{ $maintenance_center->address_en }}" class="form-control" placeholder="{{ __('Enter Address English') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="name_ru" value="{{ $maintenance_center->name_ru }}" class="form-control" placeholder="{{ __('Enter Name Russian') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="address_ru" value="{{ $maintenance_center->address_ru }}" class="form-control" placeholder="{{ __('Enter Address Russian') }}">
                                </div>

                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="numeric" name="phone" value="{{ $maintenance_center->phone }}" class="form-control" placeholder="{{ __('Enter Phone') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->
@endsection
