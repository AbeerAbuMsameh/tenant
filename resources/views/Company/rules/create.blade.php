@extends('Dashboard.master')

@section('title')
    Rules
@endsection
@section('Page-title')
    Rules
@endsection

@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('rule-create')
                    <form method="POST" action="{{ route("rules.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label for="field">Field:</label>
                                <select class="form-control" id="field" name="field" required>
                                    <option value="report_date">Report Date</option>
                                    <option value="open_date">Open Date</option>
                                    <option value="assign_date">Assign Date</option>
                                    <option value="last_resolve_date">Last Resolve Date</option>
                                    <option value="team_id">Team</option>
                                    <option value="tier1">System</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="operator">Operator:</label>
                                <select class="form-control" id="operator" name="operator" required>
                                    <option value="==">Equal to (==)</option>
                                    <option value="<>">Not equal to (!=)</option>
                                    <option value=">">Greater than (>)</option>
                                    <option value=">=">Greater than or equal to (>=)</option>
                                    <option value="<">Less than (<)</option>
                                    <option value="<=">Less than or equal to (<=)</option>
                                    <option value="IS NULL">Is Null</option>
                                    <option value="IS NOT NULL">Is Not Null</option>
                                    <option value="&">Bitwise And</option>
                                    <option value="|">Bitwise Or</option>
                                    <option value="^">Bitwise Xor</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-6">
                                <label>Value</label>
                                <input type="text" class="form-control" name="value"
                                       placeholder="Value" required/>
                            </div>
                            <div class="col-lg-6">
                                <label for="castType">Cast type:</label>
                                <select class="form-control" id="castType" name="cast">
                                    <option value=''>None</option>
                                    <option value='date'>Date</option>
                                    <option value='month'>Month</option>
                                    <option value='day'>Day</option>
                                    <option value='hour'>Hour</option>
                                    <option value='strtolower'>Lowercase</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('rule-create')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Save</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
                                    <a type="button" href="{{route('rules.index')}}"
                                       class="btn btn-white me-3">{{__('main.back')}}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan
            </div>
        </div>
    </div>
    <script>

        document.getElementById('field').addEventListener('change', function () {
            var fieldSelect = document.getElementById('field');
            var castTypeSelect = document.getElementById('castType');
            var selectedField = fieldSelect.value;
            castTypeSelect.disabled = selectedField === 'team_id' || selectedField === 'tier1';
        });
    </script>
@endsection
