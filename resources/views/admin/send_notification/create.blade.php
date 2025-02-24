@extends('admin.layout')
@section('title', __('Add Send Notification'))

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <form method="post" action="{{ route('Admin.send_notifications.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6>{{ __('Add Send Notification') }}</h6>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="title_ar" class="form-control" placeholder="{{ __('Enter Title Arabic') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="body_ar" class="form-control" placeholder="{{ __('Enter Body Arabic') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="title_en" class="form-control" placeholder="{{ __('Enter Title English') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="body_en" class="form-control" placeholder="{{ __('Enter Body English') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="title_ru" class="form-control" placeholder="{{ __('Enter Title Russian') }}">
                                </div>
                                <div class="col-6 col-xl-6 mb-3">
                                    <input type="text" name="body_ru" class="form-control" placeholder="{{ __('Enter Body Russian') }}">
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
