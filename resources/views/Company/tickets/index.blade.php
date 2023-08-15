@extends('Dashboard.master')
@section('title')
    Tickets
@endsection
@section('subTitle')
    Tickets
@endsection

@section('Page-title')
    Tickets
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
                @can('ticket-list')
                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Tickets List </h3>
                            </div>
                            @can('ticket-create')
                                <div class="card-toolbar">
                                    <a href="{{route('tickets.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4">
                                        <i class="la la-plus"></i> Create new Ticket
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
                                    <th>Number</th>
                                    <th>Report Date</th>
                                    <th>Open Date</th>
                                    <th>Assign Date</th>
                                    <th>Last Resolve Date</th>
                                    <th>Close Date</th>
                                    <th>Team</th>
                                    <th>Report Source</th>
                                    <th>Impact</th>
                                    <th>Urgency</th>
                                    <th>Priority</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tickets as $ticket)
                                    <tr data-entry-id="{{ $ticket->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ticket->ticket_num ?? '-' }}</td>
                                        <td>{{ $ticket->report_date ?? '-' }}</td>
                                        <td>{{ $ticket->open_date	 ?? '-' }}</td>
                                        <td>{{ $ticket->assign_date ?? '-' }}</td>
                                        <td>{{ $ticket->last_resolve_date ?? '-' }}</td>
                                        <td>{{ $ticket->close_date ?? '-' }}</td>
                                        <td>{{ $ticket->Team->name?? '-' }}</td>
                                        <td>{{ $ticket->report_src ?? '-' }}</td>
                                        <td>{{ $ticket->impact ?? '-' }}</td>

                                        @if($ticket->urgency == 'Low')
                                            <td class="font-weight-bold text-success">Low</td>
                                        @elseif ($ticket->urgency == 'Medium')
                                            <td class="font-weight-bold text-warning">Medium</td>
                                        @elseif ($ticket->urgency == 'High')
                                            <td class="font-weight-bold text-primary">High</td>
                                        @elseif ($ticket->urgency == 'Critical')
                                            <td class="font-weight-bold text-secondary">Critical</td>
                                        @elseif ($ticket->urgency == 'Urgent')
                                            <td class="font-weight-bold text-danger">Urgent</td>
                                        @endif

                                        @if( $ticket->priority == 'Low')
                                            <td><span
                                                    class="label label-lg font-weight-bold label-light-info label-inline">Low</span>
                                            </td>
                                        @elseif ( $ticket->priority == 'Medium')
                                            <td><span
                                                    class="label label-lg font-weight-bold label-light-warning label-inline">Medium</span>
                                            </td>
                                        @elseif ( $ticket->priority == 'High')
                                            <td><span
                                                    class="label label-lg font-weight-bold label-light-primary label-inline">High</span>
                                            </td>
                                        @elseif ( $ticket->priority == 'Critical')
                                            <td><span
                                                    class="label label-lg font-weight-bold label-light-dark label-inline">Critical</span>
                                            </td>
                                        @elseif ( $ticket->priority == 'Urgent')
                                            <td><span
                                                    class="label label-lg font-weight-bold label-light-danger label-inline">Urgent</span>
                                            </td>
                                        @endif

                                        <td>
                                            <div class="dropdown dropdown-inline"><a href="javascript:;"
                                                                                     class="btn btn-sm btn-clean btn-icon mr-2"
                                                                                     data-toggle="dropdown"> <span
                                                        class="svg-icon svg-icon-md">	                                    <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">	                                        <g
                                                                stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">	                                            <rect
                                                                    x="0" y="0" width="24" height="24"></rect>	                                            <path
                                                                    d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                                    fill="#000000"></path>	                                        </g>	                                    </svg>	                                </span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    <ul class="navi flex-column navi-hover py-2">
                                                        <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                                                            Choose an action:
                                                        </li>
                                                        @can('ticket-show')
                                                            <li class="navi-item">
                                                                <a href="{{ route('tickets.show', $ticket->id) }}"
                                                                   class="navi-link">
                                                                <span class="navi-icon">
                                                                    <i class="la la-eye"></i>
                                                                </span>
                                                                    <span class="navi-text">Show Ticket </span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('ticket-open')
                                                            <li class="navi-item">
                                                                <a class="navi-link"
                                                                   style="{{ $ticket->open_date != null ? 'cursor: default;' : '' }}"
                                                                   href="{{ $ticket->open_date != null ? '' : route('open', $ticket->id) }}">
                                                                    <span class="navi-icon">
                                                                        <i class="la la-book-open"></i>
                                                                    </span>
                                                                    <span class="navi-text">Open Ticket</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('ticket-assign')
                                                            <li class="navi-item">
                                                                <a href="#" data-bs-toggle="modal"
                                                                   data-bs-target="#kt_modal_new_target"
                                                                   data-toggle="modal" data-target="#editModal"
                                                                   title="Assign ticket"
                                                                   class="navi-link assign-ticket-btn">
                                                                    <span class="navi-icon">
                                                                    <i class="la la-address-book"></i>
                                                                    </span>
                                                                    <span class="navi-text" data-bs-toggle="modal"
                                                                          data-bs-target="#assignModal"
                                                                          data-ticket-id="{{ $ticket->id }}">
                                                                  Assign Ticket
                                                                </span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('ticket-resolve')
                                                            <li class="navi-item">
                                                                <a href="{{ route('resolve', $ticket->id) }}"
                                                                   class="navi-link">
                                                                <span class="navi-icon">
                                                                    <i class="la la-fas fa-check-double"></i>
                                                                </span>
                                                                    <span class="navi-text">Resolve Ticket</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('ticket-edit')
                                                            <li class="navi-item">
                                                                <a href="#" data-bs-toggle="modal"
                                                                   data-bs-target="#kt_modal_new_target"
                                                                   data-toggle="modal" data-target="#editTicketModal_{{$ticket->id}}"
                                                                   title="Edit ticket"
                                                                   class="navi-link edit-ticket-btn">
                                                                    <span class="navi-icon">
                                                                    <i class="la la-edit"></i>
                                                                    </span>
                                                                    <span class="navi-text" data-bs-toggle="modal"
                                                                          data-target="#editTicketModal_{{$ticket->id}}">
                                                                  Edit Ticket
                                                                </span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('ticket-close')
                                                            <li class="navi-item">
                                                                <a href="{{ route('close', $ticket->id) }}"
                                                                   class="navi-link">
                                                                <span class="navi-icon">
                                                                    <i class="la la-close"></i>
                                                                </span>
                                                                    <span class="navi-text">Close Ticket</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('ticket-delete')
                                                            <li class="navi-item">
                                                                <a onclick="sweet('{{ $ticket->id }}',this)"
                                                                   class="navi-link">
                                                                <span class="navi-icon">
                                                                    <i class="nav-icon la la-trash"></i>
                                                                </span>
                                                                    <span class="navi-text">Delete Ticket</span>
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </div>


                                        </td>
                                        <form method="POST" action="{{ route("tickets.update", $ticket->id) }}" id="formEdit" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="modal fade" id="editTicketModal_{{$ticket->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Ticket</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <i aria-hidden="true" class="ki ki-close"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row pt-4">

                                                                <div class="col-lg-12">
                                                                    <label for="tier">Tier 2</label>
                                                                    <select class="form-control {{ $errors->has('tier2') ? 'is-invalid' : '' }}"
                                                                            name="tier2" id="tier2">
                                                                        <option value="">Select Tier 2</option>
                                                                        @foreach($tiers as $tier)
                                                                            <option value="{{ $tier->id }}" {{ $tier->id == $ticket->tier2 ? 'selected' : '' }}>
                                                                                {{ $tier->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('tier2'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('tier2') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row pt-4">

                                                                <div class="col-lg-12">
                                                                    <label for="tier">Tier 3</label>
                                                                    <select class="form-control {{ $errors->has('tier3') ? 'is-invalid' : '' }}"
                                                                            name="tier3" id="tier3">
                                                                        <option value="">Select Tier 3</option>
                                                                        @foreach($tiers as $tier)
                                                                            <option
                                                                                value="{{ $tier->id }}" {{ $tier->id == $ticket->tier3 ? 'selected' : '' }}>
                                                                                {{ $tier->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if($errors->has('tier3'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('tier3') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="form-group row pt-4">

                                                                <div class="col-lg-12">
                                                                    <label for="description">Description</label>
                                                                    <div class="card-footer align-items-center">
                                <textarea class="form-control border-0 p-0" name="description" rows="2"
                                          placeholder="Type a Description">{{ $ticket->description ?? '-' }}</textarea>
                                                                    </div>
                                                                    @if($errors->has('description'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('description') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-primary font-weight-bold"
                                                                        data-dismiss="modal">
                                                                    Close
                                                                </button>

                                                                @can('ticket-edit')
                                                                    <button type="submit" class="btn btn-primary font-weight-bold">
                                                                        <span class="indicator-label">Edit</span>
                                                                    </button>
                                                                @endcan

                                                            </div>
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

    @if(!$tickets->isEmpty())
        <form action="{{ route('assign') }}" method="POST">
            @csrf
            <input type="hidden" name="assignTicketId" id="assignTicketId" value="">
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Assign Team</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">
                                Close
                            </button>

                            @can('ticket-assign')
                                <button type="submit" class="btn btn-primary font-weight-bold">
                                    <span class="indicator-label">Assign</span>
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
                        url: '/company/tickets/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your Ticket has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting ticket.',
                                'error'
                            );
                        }
                    });
                }
            });

        }

        $(document).on('click', '[data-bs-target="#assignModal"]', function () {
            var ticketId = $(this).data('ticket-id');
            $('#assignTicketId').val(ticketId);
        });


        $(document).on('click', '[data-bs-target="#editTicketModal"]', function () {
            var ticketId = $(this).data('ticket-id');
            $('#editTicketId').val(ticketId);
            $('#formEdit').attr('action', "{{ route('tickets.update', '') }}/" + ticketId);

        });

    </script>
@endsection


