@extends('admin.layout')

@section('title', __('Product Details'))

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row mb-5">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-body">
                                <h4>{{ __('Product Details') }}</h4>
                            <p><strong>{{ __('Product Name') }}:</strong> {{ $product->title ?? NULL }}</p>
                            <p><strong>{{ __('Product Description') }}:</strong> {{ $product->description ?? NULL }}</p>
                            <p><strong>{{ __('Product Price') }}:</strong> {{ $product->price  ?? NULL }}</p>
                            <p><strong>{{ __('Product Color') }}:</strong> {{ $product->color ?? NULL }}</p>
                            <p><strong>{{ __('Product Size') }}:</strong> {{ $product->size ?? NULL }}</p>
                            <p><strong>{{ __('Product Sale Status') }}:</strong> {{ $product->sale_status ?? NULL }}</p>
                            <p><strong>{{ __('Product Status') }}:</strong> {{ $product->status ?? NULL }}</p>
                            <p><strong>{{ __('Product Category') }}:</strong> {{ $product->category->title ?? NULL }}</p>
                            <p><strong>{{ __('Provider Name') }}:</strong> {{ $product->provider->provider_name ?? __('Not Defined') }}</p>
                            <p><strong>{{ __('Product Images') }}:</strong>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    @foreach ($product->images as $img)
                                        <img src="{{ asset('storage/'.$img->image) }}" alt="صورة المنتج" style="width: 150px; height: auto; border-radius: 5px;">
                                    @endforeach
                                </div>
                            </p>

                            <a href="{{ route('Admin.product.index') }}" class="btn btn-secondary">عودة</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
