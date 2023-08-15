@extends('Dashboard.master')

@section('title')
    Add ticket
@endsection
@section('Page-title')
    Ticket
@endsection

@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <form method="POST" action="{{ route("tickets.store") }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row ">
                        <div class="col-lg-6">
                            <label for="ticket_num">Ticket Number<span class="text-danger">*</span></label>
                            <input type="text" class="form-control {{ $errors->has('ticket_num') ? 'is-invalid' : '' }}"
                                   name="ticket_num" id="ticket_num" value="{{ old('ticket_num', '') }}" required
                                   placeholder="Enter Ticket Number">
                            @if($errors->has('ticket_num'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ticket_num') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <label>Report Source<span class="text-danger">*</span></label>
                            <select class="form-control {{ $errors->has('report_src') ? 'is-invalid' : '' }}"
                                    name="report_src" id="report_src" required>
                                <option value="" disabled selected>Select Report Source</option>
                                <option value="Phone" {{ old('report_src') == 'Phone' ? 'selected' : '' }}>Phone
                                </option>
                                <option value="Email" {{ old('report_src') == 'Email' ? 'selected' : '' }}>Email
                                </option>
                                <option
                                    value="Self_Service" {{ old('report_src') == 'Self_Service' ? 'selected' : '' }}>
                                    Self Service
                                </option>
                                <option
                                    value="Customer_Service" {{ old('report_src') == 'Customer_Service' ? 'selected' : '' }}>
                                    Customer Service
                                </option>
                                <option
                                    value="Technical_Team" {{ old('report_src') == 'Technical_Team' ? 'selected' : '' }}>
                                    Technical Team
                                </option>
                            </select>
                            @if($errors->has('report_src'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('report_src') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row pt-4">
                        <div class="col-lg-4">
                            <label>Impact</label>
                            <select class="form-control {{ $errors->has('impact') ? 'is-invalid' : '' }}"
                                    name="impact" id="impact">
                                <option value="" disabled selected>Select Impact</option>
                                <option value="Limited" {{ old('impact') == 'Limited' ? 'selected' : '' }}>Limited
                                </option>
                                <option value="Localized" {{ old('impact') == 'Localized' ? 'selected' : '' }}>
                                    Localized
                                </option>
                            </select>
                            @if($errors->has('impact'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('impact') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <label for="priority">Priority</label>
                            <select class="form-control {{ $errors->has('priority') ? 'is-invalid' : '' }}"
                                    name="priority" id="priority">
                                <option value="" disabled selected>Select Priority</option>
                                <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Critical" {{ old('priority') == 'Critical' ? 'selected' : '' }}>
                                    Critical
                                </option>
                                <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>Urgent
                                </option>
                            </select>
                            @if($errors->has('priority'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('priority') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4">
                            <label for="urgency">Urgency</label>
                            <select class="form-control {{ $errors->has('urgency') ? 'is-invalid' : '' }}"
                                    name="urgency" id="urgency">
                                <option value="" disabled selected>Select Urgency</option>
                                <option value="Low" {{ old('urgency') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ old('urgency') == 'Medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="High" {{ old('urgency') == 'High' ? 'selected' : '' }}>High</option>
                                <option value="Critical" {{ old('urgency') == 'Critical' ? 'selected' : '' }}>Critical
                                </option>
                                <option value="Urgent" {{ old('urgency') == 'Urgent' ? 'selected' : '' }}>Urgent
                                </option>
                            </select>
                            @if($errors->has('urgency'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('urgency') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row pt-4">
                        <div class="col-lg-12">
                            <label for="description">Description</label>
                            <div class="card-footer align-items-center">
                                <textarea class="form-control border-0 p-0" name="description" rows="2"
                                          placeholder="Type a Description"></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                @can('ticket-create')
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Save</span>
                                    </button>
                                @endcan
                                <input type="reset" value="Reset" class="btn btn-white me-3">
                                @can('ticket-list')
                                    <a type="button" href="{{route('tickets.index')}}"
                                       class="btn btn-white me-3">{{__('main.back')}}</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
