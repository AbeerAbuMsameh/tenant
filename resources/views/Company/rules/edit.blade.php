@extends('Dashboard.master')

@section('title')
    Rules
@endsection
@section('Page-title')
    Rules
@endsection
@section('js')
@endsection
@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('rule-edit')
                    <form method="POST" action="{{ route("rules.update", $rule->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="field">Field:</label>
                                <select class="form-control" id="field" name="field" required>
                                    <option value="report_date" {{ $rule->field == 'report_date' ? 'selected' : '' }}>
                                        Report Date
                                    </option>
                                    <option value="open_date" {{ $rule->field == 'open_date' ? 'selected' : '' }}>Open
                                        Date
                                    </option>
                                    <option value="assign_date" {{ $rule->field == 'assign_date' ? 'selected' : '' }}>
                                        Assign Date
                                    </option>
                                    <option
                                        value="last_resolve_date" {{ $rule->field == 'last_resolve_date' ? 'selected' : '' }}>
                                        Last Resolve Date
                                    </option>
                                    <option value="team_id" {{ $rule->field == 'team_id' ? 'selected' : '' }}>Team
                                    </option>
                                    <option value="tier1" {{ $rule->field == 'tier1' ? 'selected' : '' }}>
                                        System
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="operator">Operator:</label>
                                <select class="form-control" id="operator" name="operator" required>
                                    <option value="==" {{ $rule->operator == '==' ? 'selected' : '' }}>Equal to (=)
                                    </option>
                                    <option value="!=" {{ $rule->operator == '!=' ? 'selected' : '' }}>Not equal to
                                        (!=)
                                    </option>
                                    <option value=">" {{ $rule->operator == '>' ? 'selected' : '' }}>Greater than (>)
                                    </option>
                                    <option value=">=" {{ $rule->operator == '>=' ? 'selected' : '' }}>Greater than or
                                        equal to (>=)
                                    </option>
                                    <option value="<" {{ $rule->operator == '<' ? 'selected' : '' }}>Less than (<)
                                    </option>
                                    <option value="<=" {{ $rule->operator == '<=' ? 'selected' : '' }}>Less than or
                                        equal to (<=)
                                    </option>
                                    <option value="IS NULL" {{ $rule->operator == 'IS NULL' ? 'selected' : '' }}>Is
                                        Null
                                    </option>
                                    <option
                                        value="IS NOT NULL" {{ $rule->operator == 'IS NOT NULL' ? 'selected' : '' }}>Is
                                        Not Null
                                    </option>
                                    <option value="&" {{ $rule->operator == '&' ? 'selected' : '' }}>Bitwise And
                                    </option>
                                    <option value="|" {{ $rule->operator == '|' ? 'selected' : '' }}>Bitwise Or</option>
                                    <option value="^" {{ $rule->operator == '^' ? 'selected' : '' }}>Bitwise Xor
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-6">
                                <label>Value</label>
                                <input type="text" class="form-control" name="value" value="{{$rule->value}}"
                                       placeholder="Value" required/>
                            </div>
                            <div class="col-lg-6">
                                <label for="castType">Cast type:</label>
                                <select class="form-control" id="castType" name="cast">
                                    <option value=''>None</option>
                                    <option value='date' {{ $rule->cast == 'date' ? 'selected' : '' }}>Date</option>
                                    <option value='month' {{ $rule->cast == 'month' ? 'selected' : '' }}>Month</option>
                                    <option value='day' {{ $rule->cast == 'day' ? 'selected' : '' }}>Day</option>
                                    <option value='hour' {{ $rule->cast == 'hour' ? 'selected' : '' }}>Hour</option>
                                    <option value='strtolower' {{ $rule->cast == 'strtolower' ? 'selected' : '' }}>
                                        Lowercase
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('rule-edit')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Edit</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
                                    @can('rule-list')
                                        <a type="button" href="{{route('rules.index')}}"
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
    <script>
    </script>
@endsection
