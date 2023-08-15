@extends('Dashboard.master')
@section('title')
    Users
@endsection
@section('subTitle')
    Users
@endsection

@section('Page-title')
    Users
@endsection

@section('js')
    <script type="text/javascript">
        $("#msg").show().delay(3000).fadeOut();
    </script>
    <script>
        function sweet(id, reference) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("users.destroy", ":id") }}'.replace(':id', id),
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your user has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting user.',
                                'error'
                            );
                        }
                    });
                }
            });

        }


    </script>

@endsection
@section('content')

    <div class="flex-lg-row-fluid ms-lg-10">
        <!--begin::Card-->
        <div class="card card-flush mb-6 mb-xl-9">

            <div class="card-body pt-0">
                @if(session()->has('msg'))
                    <div class="alert alert-success" id="msg">
                        {{ session()->get('msg') }}
                    </div>
                @endif
                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Users List
                                    <span
                                        class="d-block text-muted pt-2 font-size-sm">display users</span>
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{route('users.create')}}"
                                   class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                   data-bs-target="#kt_modal_new_target">
                                    <i class="la la-plus"></i> Create new User
                                </a>

                                <!--end::Button-->
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th>Record ID</th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>company</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as  $user)

                                    <tr data-entry-id="{{ $user->id }}">
                                        <td> {{ $loop->iteration }}</td>
                                        <td>{{ $user->name ?? '' }}</td>
                                        <td>{{ $user->email ?? '' }}</td>
                                        <td>{{ $user->company->name ?? '' }}</td>
                                        <td>
                                            @if($user->roles->count() > 0)
                                                @foreach($user->roles as $role)
                                                    <p class="label font-weight-bold label-lg  label-light-primary label-inline"
                                                       id="num_of_perms_1">
                                                        {{  $role->name }}
                                                    </p>
                                                @endforeach
                                            @endif

                                        </td>
                                        @if($user->id != 1 && \Illuminate\Support\Facades\Auth::user()->email != $user->email)
                                            <td>
                                                <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2"
                                                   data-toggle="dropdown"> <span class="svg-icon svg-icon-md">	                                    <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">	                                        <g
                                                                stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">	                                            <rect
                                                                    x="0" y="0" width="24" height="24"></rect>	                                            <path
                                                                    d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                                    fill="#000000"></path>	                                        </g>	                                    </svg>	                                </span>
                                                </a>
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a onclick="sweet('{{ $user->id }}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                                    <i class="nav-icon la la-trash"></i>
                                                </a>

                                            </td>
                                        @else
                                            <td><p class="label font-weight-bold label-lg  label-light-danger label-inline"
                                                   id="num_of_perms_1">
                                                    No Actions to Super Admin
                                                </p>
                                            </td>

                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>

@endsection

