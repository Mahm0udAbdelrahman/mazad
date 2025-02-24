@extends('admin.layout')
@section('title', __('Product Rent'))

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="add d-flex justify-content-end p-2">
                        {{-- <a href="{{ route('Admin.product.create') }}" class="btn btn-primary">
                            <i class="fas fa-add"></i> {{ __('Add Product') }}
                        </a> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-center">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Product Image') }}</th>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Product Description') }}</th>
                                        <th>{{ __('Product Price') }}</th>
                                        <th>{{ __('Product Colors') }}</th>
                                        <th>{{ __('Product Size') }}</th>
                                        <th>{{ __('Product Category') }}</th>
                                        <th>{{ __('Supplier Name') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $product)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>

                                        <td>
                                            @if ($product->images->isNotEmpty())
                                                <img src="{{ asset('storage/'.$product->images->first()->image) }}" alt="{{ __('Product Image') }}"
                                                width="80" height="80"
                                                class="img-thumbnail">
                                            @endif
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($product->description, 20) }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->color }}</td>
                                        <td>{{ $product->size }}</td>
                                        <td>{{ $product->category->title }}</td>
                                        <td>{{ $product->provider->provider_name ?? null }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- View --}}
                                                @can('product_rent-قراءة')
                                                <a href="{{ route('Admin.show_product_rent', $product->id) }}" class="btn btn-info">
                                                    <i class="fas fa-eye"></i> {{ __('View') }}
                                                </a>
                                                @endcan

                                                {{-- Delete --}}
                                                @can('product_rent-مسح')
                                                <button
                                                    class="btn btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteConfirmationModal"
                                                    data-id="{{ $product->id }}">
                                                    <i class="far fa-trash-alt"></i> {{ __('Delete') }}
                                                </button>
                                                @endcan

                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10">{{ __('No Data Found') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div style="padding:5px;direction: ltr;">
                                {!! $data->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">{{ __('Confirm Deletion') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete this item?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form method="POST" id="deleteForm">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
    deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('admin/product') }}/${id}`;
    });
</script>
@endsection
