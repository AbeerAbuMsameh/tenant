@extends('Dashboard.master')
@section('title')
    Services
@endsection
@section('Page-title')
    Services
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
                @can('service-list')
                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Services List </h3>
                            </div>
                            @can('service-create')
                                <div class="card-toolbar">
                                    <a href="{{route('services.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                       data-target="#exampleModal">
                                        <i class="la la-plus"></i> Create new Service
                                    </a>
                                </div>
                            @endcan

                        </div>


                        <div class="card-body">
                            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($services as  $service)
                                    <tr data-entry-id="{{ $service->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $service->name ?? '' }}</td>
                                        <td>
                                            @can('service-edit')
                                                <a href="{{ route('services.edit', $service->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon" data-bs-toggle="modal"
                                                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                                   data-target="#editModal_{{$service->id}}" title="Edit details">
                                                    <i class="la la-edit"></i>

                                                </a>
                                            @endcan
                                            @can('service-delete')
                                                <a onclick="sweet('{{$service->id}}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                                    <i class="nav-icon la la-trash"></i>
                                                </a>
                                            @endcan
                                            @can('service-system-create')
                                                @if(!$service->service_systems->count())
                                                    <a href="{{ route('service_systems.index') }}"
                                                       class="btn btn-sm btn-clean btn-icon"
                                                       title="Add Systems"
                                                       onclick="event.preventDefault(); document.getElementById('service-form-{{ $service->id }}').submit();"
                                                    >
                                                        <i class="fab fa-buffer"></i>
                                                    </a>
                                                    <form id="service-form-{{ $service->id }}"
                                                          action="{{ route('service_systems.index') }}" method="GET"
                                                          style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="service_id"
                                                               value="{{ $service->id }}">
                                                    </form>
                                                @else
                                                    <span
                                                        class="label label-lg font-weight-bold label-light-info label-inline">Systems added</span>

                                                @endif
                                            @endcan
                                            @can('service-system-edit')
                                                <a href="{{ route('service_systems.edit', $service->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon"  title="Show & Edit systems">
                                                    <i class="la la-eye"></i>
                                                </a>
                                            @endcan
                                        </td>
                                        <form method="POST" action="{{ route("services.update", $service->id) }}" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal fade" id="editModal_{{$service->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Service</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row pt-4">

                                                                <div class="col-lg-12">
                                                                    <label for="name">Service Name<span class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                                           name="name" id="name" value="{{ old('name', $service->name) }}"
                                                                           placeholder="Enter Service Name" required/>
                                                                    @if($errors->has('name'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('name') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                                                Close
                                                            </button>

                                                            @can('service-edit')
                                                                <button type="submit" class="btn btn-primary font-weight-bold">
                                                                    <span class="indicator-label">Edit</span>
                                                                </button>
                                                            @endcan

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </tr>
                                @endforeach

                                </tbody>

                            </table>
                        </div>

                    </div>
                @endcan
            </div>

        </div>

    </div>

    <!-- Button trigger modal-->
    <!-- Modal-->
    <form method="POST" action="{{ route("services.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Service</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label for="name">Service Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       name="name" id="name" value="{{ old('name', '') }}"
                                       placeholder="Enter Service Name" required/>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                        </button>

                        @can('service-create')
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                <span class="indicator-label">Save</span>
                            </button>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal -->
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
                        url: '/company/services/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your Tier has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting Service.',
                                'error'
                            );
                        }
                    });
                }
            });

        }


    </script>
@endsection


