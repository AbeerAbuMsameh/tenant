@extends('Dashboard.master')

@section('title')
    Troubleshooting Service
@endsection

@section('Page-title')
    Troubleshooting Service
@endsection

@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('service-system-create')
                    <form method="GET" action="{{ route('sendRequests') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="service">Select Service<span class="text-danger">*</span></label>
                                <select id="service_id" name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}">
                                    <option value="">Select a Service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('service_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('service_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div id="system-chain" style="display: none;"></div>


                        <div id="service-systems-table" class="col-12" style="display: none;">

                                    <div class="table-responsive">
                                        <table id="service-systems-table-content" class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>System</th>
                                                <th>Main Host</th>
                                                <th>Sort Number</th>
                                                <th>Command</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('service-system-create')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">TroubleShoot</span>
                                        </button>
                                    @endcan
                                    <a type="button" href="{{ route('services.index') }}" class="btn btn-white me-3">{{ __('main.back') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                @endcan
            </div>
        </div>
    </div>



@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#service_id').change(function () {
                var serviceId = $(this).val();

                if (serviceId) {
                    // Show the table
                    $('#service-systems-table').show();

                    // Get service systems data using Axios
                    axios.get('/company/service_systems/' + serviceId)
                        .then(function (response) {
                            var systems = response.data.systems;

                            // Clear previous table content and system chain
                            $('#service-systems-table-content tbody').empty();
                            $('#system-chain').empty();

                            // Populate table with new data
                            for (var i = 0; i < systems.length; i++) {
                                var system = systems[i];
                                var chain = '';

                                // Create chain of system names
                                for (var j = 0; j < systems.length; j++) {
                                    var currentSystem = systems[j];
                                    chain += '<span style="width: 197px;height: 42px;margin: 50px 0px 50px;"  class="label label-lg font-weight-bold';

                                    // Add class based on position
                                    if (j === 0) {
                                        chain += ' btn btn-warning font-weight-bold ';
                                    } else if (j === systems.length - 1) {
                                        chain += ' btn btn-primary font-weight-bold';
                                    } else {
                                        chain += ' btn btn-danger font-weight-bold';
                                    }

                                    chain += ' label-inline">' + currentSystem.name + '</span>';

                                    if (j !== systems.length - 1) {
                                        chain += '<span class="arrow" style="width: 20px;">&rarr;</span>';
                                    }
                                }

                                // Append new row to the table
                                var row = '<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' + system.name + '</td>' +
                                    '<td>' + system.main_host + '</td>' +
                                    '<td>' + system.sort_num + '</td>' +
                                    '<td>' + system.command + '</td>' +
                                    '<td class="status-label label-light-info">NoRequest</td>' +
                                    '</tr>';

                                $('#service-systems-table-content tbody').append(row);
                            }

                            // Display system chain
                            $('#system-chain').html(chain).show();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                } else {
                    // Hide the table if no service is selected
                    $('#service-systems-table').hide();
                }
            });

            // Handle form submission
            $('form').submit(function (event) {
                event.preventDefault();

                // Get all table rows
                var rows = $('#service-systems-table-content tbody tr');
                var index = 0;

                // Define a recursive function to send requests sequentially
                function sendRequest() {
                    if (index < rows.length) {
                        var row = rows.eq(index);
                        var command = row.find('td:nth-child(5)').text();

                        // Make a GET request to the command using Axios
                        axios.get(command)
                            .then(function (response) {
                                // Update the status in the table row
                                row.find('.status-label')
                                    .removeClass('label-light-info')
                                    .css({
                                        'background-color': 'lightgreen',
                                        'color': '#000',
                                        /* Add more inline styles as needed */
                                    })
                                    .text('Success');
                                // Increment index and send the next request
                                index++;
                                sendRequest();
                            })
                            .catch(function (error) {
                                // Update the status in the table row
                                row.find('.status-label')
                                    .removeClass('label-light-info')
                                    .css({
                                        'background-color': 'red',
                                        'color': '#fff',
                                        /* Add more inline styles as needed */
                                    })
                                    .text('Error');

                                // Increment index and send the next request
                                index++;
                                sendRequest();
                            });
                    }
                }

                // Start sending requests
                sendRequest();
            });
        });
    </script>

@endsection
