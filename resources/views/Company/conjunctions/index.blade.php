@extends('Dashboard.master')
@section('title')
    Conjunctions
@endsection
@section('subTitle')
    Conjunctions
@endsection

@section('Page-title')
    Conjunctions
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
                        url: '/company/conjunctions/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your Conjunction has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting conjunction.',
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
                @can('conjunction-list')
                    <div class="card card-custom">

                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Conjunctions List </h3>
                            </div>
                            @can('conjunction-create')
                                <div class="card-toolbar">
                                    <a href="{{route('conjunctions.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target">
                                        <i class="la la-plus"></i> Create new Conjunction
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
                                    <th>Conjunction</th>
                                    <th>Output Field</th>
                                    <th>Output Value</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($conjunctions as $conjunction)
                                    <tr data-entry-id="{{ $conjunction->id }}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$conjunction->conjunction}}</td>
                                        <td>{{$conjunction->output_field}}</td>
                                        <td>{{$conjunction->output_value}}</td>
                                        <td>
                                            @can('conjunction-edit')
                                                <a href="{{ route('conjunctions.edit', $conjunction->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('conjunction-delete')
                                                <a onclick="sweet('{{$conjunction->id}}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete" title="Delete">
                                                    <i class="nav-icon la la-trash"></i>
                                                </a>
                                            @endcan
                                        </td>
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

@endsection

