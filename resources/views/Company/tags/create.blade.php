@extends('Dashboard.master')

@section('title')
    Tags
@endsection
@section('Page-title')
    Tags
@endsection
@section('js')

@endsection
@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('tag-create')
                    <form method="POST" action="{{ route("tags.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="tags">Tags (<small>EX:tag1,tag2,...</small>)</label>
                                <textarea class="form-control " name="words" rows="6" required></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="team">Team:</label>
                                <select class="form-control" id="team_id" name="team_id" required>
                                    <option value="" selected disabled>Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{$team->id}}">{{$team->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('tag-create')
                                        <button type="submit" class="btn btn-primary">
                                             <span class="indicator-label">Save</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
                                    <a type="button" href="{{route('tags.index')}}"
                                       class="btn btn-white me-3">{{__('main.back')}}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection
