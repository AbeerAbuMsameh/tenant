@extends('Dashboard.master')

@section('title')
    Conjunctions
@endsection
@section('Page-title')
    Conjunctions
@endsection

@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Initialize draggable and droppable elements -->
    <script>
        $(document).ready(function () {
            // Make rules , AND OR draggable
            $('.draggable').draggable({
                helper: function () {
                    return $(this).clone().appendTo('body').css({
                        'position': 'absolute',
                        'z-index': 1000,
                        'opacity': 0.7
                    });
                },
                revert: 'invalid',
            });

            // Make Expression textarea droppable
            $('.droppable').droppable({
                drop: function (event, ui) {
                    // Append dropped element to Expression textarea
                    $(this).val(function (index, value) {
                        var cursorPosition = this.selectionStart;
                        var textBefore = value.substring(0, cursorPosition);
                        var textAfter = value.substring(cursorPosition, value.length);
                        return textBefore + ui.draggable.text() + ' ' + textAfter;
                    });
                }
            });

        });
    </script>

@endsection
@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('conjunction-create')
                    <form method="POST" action="{{ route("conjunctions.update" ,$conjunction->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <div class="col-lg-9">
                                <label for="field">Rules:</label>
                                <table class="table table-striped">
                                    <tbody>
                                    @foreach($rules as $rule)

                                        <tr>
                                            <td>{{$rule->id}})</td>
                                            <td class="rule draggable">{{ 'if (' . $rule->field . ' ' .$rule->operator . ' ' . ($rule->value) . ')' }}</td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-3">
                                <label for="conjunction">Conjunction:</label>
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr class=" draggable">
                                        <td>&&</td>
                                    </tr>
                                    <tr class=" draggable">
                                        <td>||</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-9">
                                <label for="conjunction">Expression:</label>
                                <textarea class="form-control droppable" id="conjunction" name="conjunction"
                                          rows="15">{{$conjunction->conjunction}}</textarea>
                            </div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="output_field">Output Field:</label>
                                        <select class="form-control" id="output_field" name="output_field" required>
                                            <option
                                                value="Urgency" {{ $conjunction->output_field == 'Urgency' ? 'selected' : '' }}>
                                                Urgency
                                            </option>
                                            <option
                                                value="Priority" {{ $conjunction->output_field == 'Priority' ? 'selected' : '' }}>
                                                Priority
                                            </option>
                                            <option
                                                value="Impact" {{ $conjunction->output_field == 'Impact' ? 'selected' : '' }}>
                                                Impact
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <label for="output_value">Output Value:</label>
                                        <select class="form-control" id="output_value" name="output_value" required>
                                            @if($conjunction->output_field == 'Impact')
                                                <option
                                                    value="Limited" {{ $conjunction->output_value == 'Limited' ? 'selected' : '' }}>
                                                    Limited
                                                </option>
                                                <option
                                                    value="Localized" {{ $conjunction->output_value == 'Localized' ? 'selected' : '' }}>
                                                    Localized
                                                </option>
                                            @else
                                                <option
                                                    value="Low" {{ $conjunction->output_value == 'Low' ? 'selected' : '' }}>
                                                    Low
                                                </option>
                                                <option
                                                    value="Medium" {{ $conjunction->output_value == 'Medium' ? 'selected' : '' }}>
                                                    Medium
                                                </option>
                                                <option
                                                    value="High" {{ $conjunction->output_value == 'High' ? 'selected' : '' }}>
                                                    High
                                                </option>
                                                <option
                                                    value="Critical" {{ $conjunction->output_value == 'Critical' ? 'selected' : '' }}>
                                                    Critical
                                                </option>
                                                <option
                                                    value="Urgent" {{ $conjunction->output_value == 'Urgent' ? 'selected' : '' }}>
                                                    Urgent
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('conjunction-create')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Save</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
                                    <a type="button" href="{{route('conjunctions.index')}}"
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
        const outputField = document.getElementById('output_field');
        const outputValue = document.getElementById('output_value');

        // Add event listener to outputField select element
        outputField.addEventListener('change', function () {
            // Get the selected option value
            const selectedOption = outputField.options[outputField.selectedIndex].value;

            // Set the options of the outputValue select element based on the selected outputField value
            if (selectedOption === 'Impact') {
                outputValue.innerHTML = `
                <option value="Limited">Limited</option>
                <option value="Localized">Localized</option>
            `;
            } else {
                outputValue.innerHTML = `
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
                <option value="Critical">Critical</option>
                <option value="Urgent">Urgent</option>
            `;
            }
        });
    </script>
@endsection
