@extends('Dashboard.master')
@section('title')
    Tiers
@endsection
@section('subTitle')
    Tiers
@endsection

@section('Page-title')
    Tiers
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
                @can('tier-list')
                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Tiers List </h3>
                            </div>
                            @can('tier-create')
                                <div class="card-toolbar">
                                    <a href="{{route('tiers.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                       data-target="#exampleModal">
                                        <i class="la la-plus"></i> Create new Tier
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
                                    <th>Number</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tiers as  $tier)
                                    <tr data-entry-id="{{ $tier->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tier->name ?? '' }}</td>
                                        <td>{{ $tier->number ?? '' }}</td>
                                        <td>
                                            @can('tier-edit')
                                                <a href="{{ route('tiers.edit', $tier->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon" data-toggle="modal"
                                                   data-target="#editModal_{{$tier->id}}" title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('tier-delete')
                                                <a onclick="sweet('{{$tier->id}}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
                                                    <i class="nav-icon la la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                        <form method="POST" action="{{ route("tiers.update", $tier->id) }}" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal fade" id="editModal_{{$tier->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Tier</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row pt-4">

                                                                <div class="col-lg-6">
                                                                    <label for="name">Tier Name<span class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                                           name="name" id="name" value="{{ old('name', $tier->name) }}"
                                                                           placeholder="Enter Tier Name" required/>
                                                                    @if($errors->has('name'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('name') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label for="name">Tier Number<span class="text-danger">*</span></label>
                                                                    <input type="number" min="2" max="3"
                                                                           class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}"
                                                                           name="number" id="number" value="{{ old('number', $tier->number) }}"
                                                                           placeholder="Enter Tier Number" required/>
                                                                    @if($errors->has('number'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('number') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                                                Close
                                                            </button>

                                                            @can('tier-edit')
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
    <form method="POST" action="{{ route("tiers.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Tier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">

                            <div class="col-lg-6">
                                <label for="name">Tier Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       name="name" id="name" value="{{ old('name', '') }}"
                                       placeholder="Enter Tier Name" required/>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="name">Tier Number<span class="text-danger">*</span></label>
                                <input type="number" min="2" max="3"
                                       class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}"
                                       name="number" id="number" value="{{ old('name', '') }}"
                                       placeholder="Enter Tier Number" required/>
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

                        @can('tier-create')
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                <span class="indicator-label">Save</span>
                            </button>
                        @endcan

                    </div>
                </div>
            </div>
        </div>
    </form>
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
                        url: '/company/tiers/' + id,
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
                                'There was an error deleting tier.',
                                'error'
                            );
                        }
                    });
                }
            });

        }


    </script>
@endsection


