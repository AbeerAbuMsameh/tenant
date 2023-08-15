@extends('Dashboard.master')


@section('subTitle')
    {{__('main.edit') .' '.__('main.role')}}
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('input[name="select-all"]').change(function () {
                $('input[name="permissions[]"]').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endsection

@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <form method="POST" action="{{ route("roles.update", $role) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('main.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                               name="name" id="name" value="{{ old('name', $role->name) }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group pt-4 pb-4">
                        <div class="row">
                            <div class="col-xl-9">

                            <label class="required" for="permissions">{{ trans('Permissions') }}</label>
                            </div>
                            <div class="col-xl-3">

                                <span class="switch switch-sm switch-icon">
                                <label>
                                    <input type="checkbox" id="select-all" name="select-all"> <small>Select All</small>
                                    <span></span>
                                </label>
                            </span>
                            </div>
                        </div>
                    @foreach($permissions as $index => $permission)
                            @if($index % 3 == 0)
                                <div class="row">
                                    @endif
                                    <div class="col-sm-4">
                                        <div class="form-check pt-4">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                   class="form-check-input"
                                                   @if(old('permissions') || in_array($permission->id,$rolePermissions)) checked @endif>
                                            <label class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                    @if(($index + 1) % 3 == 0)
                                </div>
                            @endif
                        @endforeach
                        @if($errors->has('permissions'))
                            <div class="invalid-feedback">
                                {{ $errors->first('permissions') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Edit</span>
                                    </button>
                                <input type="reset" value="Reset" class="btn btn-white me-3">
                                    <a type="button" href="{{route('roles.index')}}"
                                       class="btn btn-white me-3">{{__('main.back')}}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
