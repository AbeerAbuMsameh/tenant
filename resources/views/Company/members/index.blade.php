@extends('Dashboard.master')
@section('title')
    Members
@endsection
@section('subTitle')
    Members
@endsection

@section('Page-title')
    Members
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
                @can('member-list')

                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Members List </h3>
                            </div>
                            @can('member-create')
                                <div class="card-toolbar">
                                    <a href="{{route('members.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                       data-target="#exampleModal">
                                        <i class="la la-plus"></i> Create new member
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
                                    <th>Position</th>
                                    <th>Team</th>
                                    <th>User</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($members as  $member)
                                    <tr data-entry-id="{{ $member->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $member->name ?? '' }}</td>
                                        <td>{{ $member->position ?? '' }}</td>
                                        <td>{{ $member->Team->name ?? '' }}</td>
                                        <td>{{ \App\Models\User::findOrFail($member->user_id)->name ?? '' }}</td>
                                        <td>
                                            @can('member-edit')
                                                <a href="{{ route('members.edit', $member->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon" data-bs-toggle="modal"
                                                   data-bs-target="#kt_modal_new_target" data-toggle="modal"
                                                   data-target="#editModal_{{$member->id}}" title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('member-delete')
                                                <a onclick="sweet('{{$member->id}}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete pr-" title="Delete">
                                                    <i class="nav-icon la la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                        <form method="POST" action="{{ route("members.update", $member->id) }}"
                                              enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal fade" id="editModal_{{$member->id}}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                Member</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row pt-4">
                                                                <div class="col-lg-12">
                                                                    <label for="name">Member Name<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                                           name="name" id="name"
                                                                           value="{{ old('name', $member->name) }}"
                                                                           placeholder="Enter Member Name" required/>
                                                                    @if($errors->has('name'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('name') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row pt-4">

                                                                <div class="col-lg-12">
                                                                    <label for="team">Position<span class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                           class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}"
                                                                           name="position" id="position" required
                                                                           value="{{ old('position', $member->position) }}"
                                                                           placeholder="Enter Systeam IP"/>
                                                                    @if($errors->has('position'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('position') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row pt-4">
                                                                <div class="col-lg-12">
                                                                    <label for="team">Team<span
                                                                            class="text-danger">*</span></label>
                                                                    <select
                                                                        class="form-control {{ $errors->has('team') ? 'is-invalid' : '' }}"
                                                                        name="team_id" id="team" required>
                                                                        <option value="">Select Team</option>
                                                                        @foreach($teams as $team)
                                                                            <option
                                                                                value="{{ $team->id }}" {{ $team->id == $member->team_id ? 'selected' : '' }}>
                                                                                {{ $team->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('team'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('team') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row pt-4">
                                                                <div class="col-lg-12">
                                                                    <label for="team">User<span
                                                                            class="text-danger">*</span></label>
                                                                    <select
                                                                        class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                                                        name="user_id" id="user_id" required>
                                                                        <option value="">Select User</option>
                                                                        @foreach($users as $user)
                                                                            <option
                                                                                value="{{ $user->id }}" {{ $user->id == $member->user_id ? 'selected' : '' }}>
                                                                                {{ $user->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('user_id'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('user_id') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                    class="btn btn-light-primary font-weight-bold"
                                                                    data-dismiss="modal">Close
                                                            </button>

                                                            @can('member-edit')
                                                                <button type="submit"
                                                                        class="btn btn-primary font-weight-bold">
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
                        @endcan
                    </div>
            </div>

        </div>

    </div>

    <!-- Button trigger modal-->

    <!-- Modal-->
    <form method="POST" action="{{ route("members.store") }}" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="name">Member Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       name="name" id="name" value="{{ old('name', '') }}"
                                       placeholder="Enter Member Name" required/>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row pt-4">

                            <div class="col-lg-12">
                                <label for="team">Position<span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control {{ $errors->has('position') ? 'is-invalid' : '' }}"
                                       name="position" id="position" required value="{{ old('position', '') }}"
                                       placeholder="Enter Systeam IP"/>
                                @if($errors->has('position'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('position') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="team">Team<span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('team') ? 'is-invalid' : '' }}"
                                        name="team_id" id="team" required>
                                    <option value="">Select Team</option>
                                    @foreach($teams as $team)
                                        <option
                                            value="{{ $team->id }}" {{ old('team') == $team->id ? 'selected' : '' }}>
                                            {{ $team->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('team_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('team') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label for="user_id">User<span class="text-danger">*</span></label>
                                <select class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}"
                                        name="user_id" id="user_id" required>
                                    <option value="">Select User</option>
                                    @foreach($users as $user)
                                        <option
                                            value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('user_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('user_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close
                        </button>
                        @can('member-create')
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
                        url: '/company/members/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your Member has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting Member.',
                                'error'
                            );
                        }
                    });
                }
            });

        }


    </script>

@endsection


