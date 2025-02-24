@extends('admin.layout')
@section('title', __('Add Maintenance Center'))

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <form method="post" action="{{ route('Admin.maintenance_centers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6>{{ __('Add Maintenance Center') }}</h6>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="name_ar" class="form-control" placeholder="{{ __('Enter Name Arabic') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="address_ar" class="form-control" placeholder="{{ __('Enter Address Arabic') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="name_en" class="form-control" placeholder="{{ __('Enter Name English') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="address_en" class="form-control" placeholder="{{ __('Enter Address English') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="name_ru" class="form-control" placeholder="{{ __('Enter Name Russian') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="address_ru" class="form-control" placeholder="{{ __('Enter Address Russian') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="numeric" name="phone" class="form-control" placeholder="{{ __('Enter Phone') }}">
                                </div>
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
