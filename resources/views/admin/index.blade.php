@extends('admin.layout')
@section('title', __('Home'))

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-users text-primary"></i> {{ __('Number of vendors') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold">{{ $vendor }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-truck text-warning"></i> {{ __('Number of merchants') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold">{{ $merchant }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-list text-success"></i> {{ __('Number of car') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold">{{ $car }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-box text-info"></i> {{ __('Number of products providers') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold"></h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-shopping-cart text-danger"></i> {{ __('Number of dropshipping products') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold"></h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-check-circle text-success"></i> {{ __('Number of completed withdrawals') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold"></h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-clock text-warning"></i> {{ __('Number of dropshipping products') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold"></h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-shopping-bag text-primary"></i>{{__('Number of orders')}}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold"></h2>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                                <div>
                                    <h5 class="mb-0">
                                        <i class="fa fa-map-marker-alt text-danger"></i> {{ __('Number of shipping provinces') }}
                                    </h5>
                                </div>
                            </div>
                            <h2 class="mt-4 fw-bold"></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
