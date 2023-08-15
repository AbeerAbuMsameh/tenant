@extends('Dashboard.master')
@section('title')
    Roles
@endsection
@section('subTitle')
    Roles
@endsection

@section('Page-title')
    Roles
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
                                <h3 class="card-label">Roles List
                                    <span
                                        class="d-block text-muted pt-2 font-size-sm">display roles of users</span>
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{route('roles.create')}}"
                                   class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                   data-bs-target="#kt_modal_new_target">
                                    <i class="la la-plus"></i> Create new Role
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
                                    <th>Permission</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as  $role)

                                    <tr data-entry-id="{{ $role->id }}">
                                        <td> {{ $loop->iteration }}</td>
                                        <td>{{ $role->name ?? '' }}</td>
                                        <td><p class="label font-weight-bold label-lg  label-light-primary label-inline"
                                               id="num_of_perms_1">
                                                {{ $role->permissions->count() }} Permission/s
                                            </p>
                                        </td>

                                        @if($role->id != 1)
                                            <td>
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                       class="btn btn-sm btn-clean btn-icon"
                                                       title="Edit details">
                                                        <i class="la la-edit"></i>
                                                    </a>
                                                        <a onclick="sweet('{{$role->id}}',this)"
                                                       class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                                        <i class="nav-icon la la-trash"></i>
                                                    </a>
                                            </td>
                                        @else
                                            <td>
                                                <p class="label font-weight-bold label-lg  label-light-danger label-inline"
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


@section('js')

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
                        url: '{{ route("roles.destroy", ":id") }}'.replace(':id', id),
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            console.log(response)
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your role has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting role.',
                                'error'
                            );
                        }
                    });
                }
            });

        }


    </script>

@endsection
