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
                @can('tag-edit')
                    <form method="POST" action="{{ route("tags.update", $tag->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="tags">Tags (<small>EX:tag1,tag2,...</small>)</label>
                                <textarea class="form-control " name="words" rows="6"
                                          required>{{$tag->words}}</textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="team">Team:</label>
                                <select class="form-control" id="team_id" name="team_id" required>
                                    <option value="" selected disabled>Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{$team->id}}"
                                                @if($team->id == $tag->team_id) selected @endif>{{$team->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('tag-edit')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Edit</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
                                    @can('tag-list')
                                        <a type="button" href="{{route('tags.index')}}"
                                           class="btn btn-white me-3">{{__('main.back')}}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan
            </div>
        </div>
    </div>
@endsection
