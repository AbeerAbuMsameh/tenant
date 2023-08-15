@extends('Dashboard.master')
@section('title')
    Systems
@endsection
@section('subTitle')
    Systems
@endsection

@section('Page-title')
    Systems
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
                @can('system-list')
                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Systems List </h3>
                            </div>
                            @can('system-create')
                                <div class="card-toolbar">
                                    <a href="{{route('systems.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                       data-target="#exampleModal">
                                        <i class="la la-plus"></i> Create new System
                                    </a>
                                </div>
                            @endcan
                        </div>

                        <div class="card-body">
                            <!--begin: Datatable-->
                            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>IP</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($systems as  $system)
                                    <tr data-entry-id="{{ $system->id }}">
                                        <td> {{ $loop->iteration }}</td>
                                        <td>{{ $system->name ?? '' }}</td>
                                        <td>{{ $system->main_host ?? '' }}</td>
                                        <td>
                                            @can('system-edit')
                                                <a href="{{ route('systems.edit', $system->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon" data-bs-toggle="modal"
                                                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                                   data-target="#editModal_{{ $system->id }}" title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('system-delete')
                                                <a onclick="sweet('{{$system->id}}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                                    <i class="nav-icon la la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                            <form method="POST" action="{{ route("systems.update", $system->id) }}" enctype="multipart/form-data">
                                                @method('PUT')
                                                @csrf
                                                <div class="modal fade" id="editModal_{{ $system->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel">Edit System</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group row pt-4">

                                                                    <div class="col-lg-6">
                                                                        <label for="name">System Name<span class="text-danger">*</span></label>
                                                                        <input type="text"
                                                                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                                               name="name" id="name" value="{{ old('name', $system->name) }}"
                                                                               placeholder="Enter System Name" required/>
                                                                        @if($errors->has('name'))
                                                                            <div class="invalid-feedback">
                                                                                {{ $errors->first('name') }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label for="main_host">Main Host<span class="text-danger">*</span></label>
                                                                        <input type="main_host"
                                                                               class="form-control {{ $errors->has('main_host') ? 'is-invalid' : '' }}"
                                                                               name="main_host" id="main_host" required
                                                                               value="{{ old('main_host', $system->main_host) }}"
                                                                               placeholder="Enter System IP"/>
                                                                        @if($errors->has('main_host'))
                                                                            <div class="invalid-feedback">
                                                                                {{ $errors->first('main_host') }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                                                    Close
                                                                </button>

                                                                @can('system-edit')
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
    <form method="POST" action="{{ route("systems.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add System</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="col-lg-6">
                                <label for="name">System Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       name="name" id="name" value="{{ old('name', '') }}"
                                       placeholder="Enter System Name" required/>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="main_host">Main Host<span class="text-danger">*</span></label>
                                <input type="main_host"
                                       class="form-control {{ $errors->has('main_host') ? 'is-invalid' : '' }}"
                                       name="main_host" id="main_host" required value="{{ old('main_host', '') }}"
                                       placeholder="Enter System IP"/>
                                @if($errors->has('main_host'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('main_host') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                        </button>

                        @can('system-create')
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                <span class="indicator-label">Save</span>
                            </button>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </form>
    @if(!$systems->isEmpty())
        <form method="POST" action="{{ route("systems.update", $system->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="modal fade" id="editModal_{{ $system->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit System</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row pt-4">

                                <div class="col-lg-6">
                                    <label for="name">System Name<span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           name="name" id="name" value="{{ old('name', $system->name) }}"
                                           placeholder="Enter System Name" required/>
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <label for="main_host">Main Host<span class="text-danger">*</span></label>
                                    <input type="main_host"
                                           class="form-control {{ $errors->has('main_host') ? 'is-invalid' : '' }}"
                                           name="main_host" id="main_host" required
                                           value="{{ old('main_host', $system->main_host) }}"
                                           placeholder="Enter System IP"/>
                                    @if($errors->has('main_host'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('main_host') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                Close
                            </button>

                            @can('system-edit')
                                <button type="submit" class="btn btn-primary font-weight-bold">
                                    <span class="indicator-label">Edit</span>
                                </button>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif

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
                        url: '/company/systems/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your system has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting system.',
                                'error'
                            );
                        }
                    });
                }
            });

        }


    </script>

@endsection


