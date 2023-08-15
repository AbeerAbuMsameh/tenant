@extends('Dashboard.master')


@section('subTitle')
    {{__('main.show') .' '. __('main.role')}}
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                    <table class="table table-row-bordered border-1 table-striped table-hover">
                        <tbody>
                        <tr>
                            <th>
                                ID
                            </th>
                            <td>
                                {{ $role->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('main.name') }}
                            </th>
                            <td>
                                {{ $role->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ __('dashboard.permissions') }}
                            </th>
                            <td>
                                @foreach($role->permissions as $key => $permissions)
                                    <span class="badge badge-info small">
                                    {{$permissions->name}}
                                    </span>
                                @endforeach
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <a class="btn btn-secondary" href="{{ route('roles.index') }}">
                            {{ __('main.back') }}
                        </a>
                    </div>
            </div>
        </div>
    </div>

@endsection
