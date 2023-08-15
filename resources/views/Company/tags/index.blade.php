@extends('Dashboard.master')
@section('title')
    Tags
@endsection
@section('subTitle')
    Tags
@endsection

@section('Page-title')
    Tags
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
                        url: '/company/tags/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            reference.closest('tr').remove();
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Your tag has been deleted.',
                                'success'
                            );
                        },
                        error: function (xhr, status, error) {
                            console(error);
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting tag.',
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
                @can('tag-list')
                    <div class="card card-custom">
                        <div class="card-header flex-wrap py-5">
                            <div class="card-title">
                                <h3 class="card-label">Tags List </h3>
                            </div>
                            @can('tag-create')
                                <div class="card-toolbar">
                                    <a href="{{route('tags.create')}}"
                                       class="btn btn-sm btn-light-primary er fs-6 px-8 py-4" data-bs-toggle="modal"
                                       data-bs-target="#kt_modal_new_target">
                                        <i class="la la-plus"></i> Create new Tags
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
                                    <th>Words</th>
                                    <th>Team</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tags as $tag)
                                    <tr data-entry-id="{{ $tag->id }}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{substr($tag->words, 0, 100)}}</td>
                                        <td>{{$tag->team->name}}</td>
                                        <td>
                                            @can('tag-edit')
                                                <a href="{{ route('tags.edit', $tag->id) }}"
                                                   class="btn btn-sm btn-clean btn-icon"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                            @endcan
                                            @can('tag-delete')
                                                <a onclick="sweet('{{$tag->id}}',this)"
                                                   class="btn btn-sm btn-clean btn-icon btn-delete " title="Delete">
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


