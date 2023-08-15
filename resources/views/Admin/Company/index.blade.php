@extends('Dashboard.master')
@section('title')
    Companies
@endsection
@section('subTitle')
    Companies
@endsection

@section('Page-title')
    Companies
@endsection

@section('js')
    <script type="text/javascript">
        $("#msg").show().delay(3000).fadeOut();
    </script>

        <script>
            function sweets(id, reference) {
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
                            url: '/superAdmin/companies/' + id,
                            method: 'DELETE',
                            data: {_token: '{{ csrf_token() }}'},
                            success: function (response) {
                                reference.closest('tr').remove();
                                // Show the success message
                                Swal.fire(
                                    'Deleted!',
                                    'Your Company has been deleted.',
                                    'success'
                                );
                            },
                            error: function (xhr, status, error) {
                                // Show the error message
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting company.',
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
                @can('company-list')
                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Companies List </h3>
                            </div>
                            @can('company-create')
                                <div class="card-toolbar">
                                    <a href="{{route('companies.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target">
                                        <i class="la la-plus"></i> Create new Company
                                    </a>

                                    <!--end::Button-->
                                </div>
                            @endcan
                        </div>
                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Website</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($companies as $company)
                                    <tr data-entry-id="{{ $company->id }}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>@if ($company->logo)
                                                <img class="pr-4" src="{{asset($company->logo)}}" height="50px"
                                                     width="50px"
                                                     alt="Logo">
                                            @endif </td>
                                        <td>{{$company->name}}</td>
                                        <td>{{$company->address}}</td>
                                        <td><a href="{{$company->website}}">{{$company->website}}</a></td>
                                        <td>{{$company->email}}</td>
                                        <td>{{$company->phone}}</td>
                                        @if($company->active == 1 )
                                            <td data-field="Status" data-autohide-disabled="false" aria-label="3"
                                                class="datatable-cell"><span style="width: 108px;"><span
                                                        class="label font-weight-bold label-lg  label-light-primary label-inline">Active</span></span>
                                            </td>
                                        @else
                                            <td data-field="Status" data-autohide-disabled="false" aria-label="2"
                                                class="datatable-cell"><span style="width: 108px;"><span
                                                        class="label font-weight-bold label-lg  label-light-danger label-inline">Not Active</span></span>
                                            </td>
                                        @endif
                                        <td>
                                            @can('company-edit')
                                                <a href="{{ route('companies.edit', $company->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('company-delete')
                                                <a onclick="sweets('{{$company->id}}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                                    <i class="nav-icon la la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>

                                @endforeach
                                </tbody>

                            </table>
                            {{ $companies->links() }}
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>

@endsection

