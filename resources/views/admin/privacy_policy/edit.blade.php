@extends('admin.layout')

@section('title', __('Edit Privacy Policy'))

@section('content')
    <main class="main-wrapper">
        <div class="main-content">
            <div class="row mb-5">
                <div class="col-12 col-xl-12">
                    <div class="card">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ __('Success Message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
                            </div>
                        @endif

                        <div class="card shadow-lg rounded-3">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">{{ __('Edit Privacy Policy') }}</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('Admin.privacy_policy.update') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="message_ar" class="form-label">{{ __('Privacy Policy (Arabic)') }}</label>
                                        <textarea id="message_ar" name="message_ar" class="form-control @error('message_ar') is-invalid @enderror" rows="6">{{ old('message_ar', $privacy_policy->message_ar ?? '') }}</textarea>
                                        @error('message_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="message_en" class="form-label">{{ __('Privacy Policy (English)') }}</label>
                                        <textarea id="message_en" name="message_en" class="form-control @error('message_en') is-invalid @enderror" rows="6">{{ old('message_en', $privacy_policy->message_en ?? '') }}</textarea>
                                        @error('message_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="message_ru" class="form-label">{{ __('Privacy Policy (Russian)') }}</label>
                                        <textarea id="message_ru" name="message_ru" class="form-control @error('message_ru') is-invalid @enderror" rows="6">{{ old('message_ru', $privacy_policy->message_ru ?? '') }}</textarea>
                                        @error('message_ru')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
