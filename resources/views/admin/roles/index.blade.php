@extends('admin.layout')
@section('title', __('Roles'))

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="add d-flex justify-content-end p-2">
                        @can('roles-create')
                        <a href="{{ route('Admin.roles.create') }}" class="btn btn-primary">
                            <i class="fas fa-add"></i> {{ __('Add Role') }}
                        </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-center">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Permissions Count') }}</th>
                                        <th>{{ __('Users Count') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ count($role->permissions) }}</td>
                                        <td>{{ count($role->users) }}</td>
                                        <td>
                                            @can('roles-delete')
                                            <button type="button" onclick="deleteId({{ $role->id }})" class="btn btn-danger w-25">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                            @endcan
                                            @can('roles-update')
                                            <a href="{{ route('Admin.roles.edit', $role) }}" class="btn btn-info w-25">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">{{ __('No data available!') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div style="padding:5px;direction: ltr;">
                                {!! $roles->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--end main wrapper-->
@endsection

@push('scripts')
<script>
    function deleteId(id) {
        Swal.fire({
            title: '{{ __("Are you sure?") }}',
            text: "{{ __('Do you want to delete this item?') }}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC143C',
            cancelButtonColor: '#696969',
            cancelButtonText: "{{ __('Cancel') }}",
            confirmButtonText: '{{ __("Yes, delete it!") }}'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/admin/delete/role/' + id;
            }
        });
    }
</script>
@endpush
