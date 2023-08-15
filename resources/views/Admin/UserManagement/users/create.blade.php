@extends('Dashboard.master')

@section('title')
    Add User
@endsection
@section('Page-title')
    Add User
@endsection
@section('js')
    <script>
        $("#msg").show().delay(7000).fadeOut();
    </script>
@endsection

@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <form method="POST" action="{{ route("users.store") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="name">User Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                   name="name" id="name" value="{{ old('name', '') }}" required
                                   placeholder="Enter User Name">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <label>User Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                   name="email" id="email" value="{{ old('email', '') }}" required
                                   placeholder="Enter User Email">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row pt-4">
                        <div class="col-lg-6">
                            <label for="password">{{__('main.password')}}<span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   name="password" id="password"
                                   placeholder="{{__('main.password')}}" required/>
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-6">
                            <label for="password_confirmation">{{__('main.password_confirmation')}}<span
                                    class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   required placeholder="{{__('main.password_confirmation')}}"/>
                        </div>
                    </div>
                    <div class="form-group pt-4 pb-4">
                        <label class="required" for="roles">{{ trans('Roles') }} <span
                                class="text-danger">*</span>
                        </label>
                        @foreach($roles as $index => $role)
                            @if($index % 3 == 0)
                                <div class="row" style="padding-bottom: 20px;">
                                    @endif
                                    <div class="col-sm-4">
                                        <div class="form-check pt-4">
                                            <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                                   class="form-check-input"
                                                   @if(old('roles') && in_array($role->id, old('roles'))) checked @endif>
                                            <label class="form-check-label">{{ $role->name }}</label>
                                        </div>
                                    </div>
                                    @if(($index + 1) % 3 == 0)
                                </div>
                            @endif
                        @endforeach
                        @if($errors->has('roles'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Save</span>
                                    </button>
                                <input type="reset" value="Reset" class="btn btn-white me-3">
                                <a type="button" href="{{route('users.index')}}"
                                   class="btn btn-white me-3">{{__('main.back')}}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
