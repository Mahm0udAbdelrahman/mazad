@extends('admin.layout')
@section('title', __('Notifications'))

@section('content')
<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        <div class="row mb-5">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="add d-flex justify-content-end p-2"></div>
                    <div class="card-body">
                        <div class="table-responsive text-center">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Message') }}</th>
                                        <th>{{ __('Created_at') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notifications as $notification)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $notification->data['status'] }}</td>
                                        <td>{{ $notification->data['message'] }}</td>
                                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if($notification->read_at)
                                                <button class="btn btn-outline-danger btn-sm  delete-country-btn delete-country-btn"
                                                   data-id="{{ $notification->id }}"
                                                    title="{{ __('Delete') }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            @else
                                                @can('notifications-مسح')
                                                <button class="btn btn-danger btn-sm  delete-country-btn delete-country-btn"
                                                   data-id="{{ $notification->id }}"
                                                    title="{{ __('Delete') }}">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                                @endcan

                                                @can('notifications-قراءة')
                                                <a href="{{ route('Admin.edit_transaction_history_pending', $notification->data['order_id']) }}?notification_id={{ $notification->id }}"
                                                    class="btn btn-success btn-sm mark-as-read"
                                                    data-id="{{ $notification->id }}"
                                                    title="{{ __('Mark_as_read') }}">
                                                    <i class="far fa-envelope-open"></i>
                                                </a>
                                                @endcan
                                            @endif
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">{{ __('No_notifications') }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div style="padding:5px;direction: ltr;">
                                {!! $notifications->withQueryString()->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
   <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.delete-country-btn').forEach(button => {
            button.addEventListener('click', function () {
                let id = this.getAttribute('data-id');

                Swal.fire({
                    title: '{{ __("Are you sure?") }}',
                    text: "{{ __('Do you want to delete this item') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DC143C',
                    cancelButtonColor: '#696969',
                    cancelButtonText: "{{ __('Cancel') }}",
                    confirmButtonText: '{{ __("Yes, delete it!") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.action = '{{ url("/admin/notifications") }}/' + id;
                        form.method = 'POST';
                        form.style.display = 'none';

                        let csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = '{{ csrf_token() }}';

                        let methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';

                        form.appendChild(csrfInput);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endpush

@endsection
