@extends('admin.layout')
@section('title',__('Users'))

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="add d-flex justify-content-end p-2">
                        @can('users-create')
                        <a href="{{ route('Admin.users.create') }}" class="btn btn-primary"> <i class="fas fa-add"></i> {{ __('Add User') }}</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-center">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Service') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->service }}</td>
                                        <td>{{ $user->category }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>
                                            @can('users-delete')
                                                <button type="button" onclick="deleteId({{ $user->id }})" class="btn btn-danger w-25"><i class="far fa-trash-alt"></i></button>
                                            @endcan
                                            @can('users-update')
                                            <a href="{{ route('Admin.users.edit',$user) }}" class="btn btn-info w-25"><i class="fas fa-edit"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">{{ __('Nothing!') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div style="padding:5px;direction: ltr;">
                                {!! $users->withQueryString()->links('pagination::bootstrap-5') !!}
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
                title: '{{ __("Are you sure?",[],"ar") }}',
                text: "{{ __('Do you want to delete this item',[],'ar') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC143C',
                cancelButtonColor: '#696969',
                cancelButtonText: "{{ __('Cancel',[],'ar') }}",
                confirmButtonText: '{{ __("Yes, delete it!",[],"ar") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/admin/delete/user/' + id;
                }
            });
        }
   </script>
@endpush
