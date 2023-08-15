@extends('Dashboard.master')
@section('title')
    Show & Edit Systems
@endsection
@section('Page-title')
    Show & Edit Services
@endsection
@section('js')
    <script>
        function updateSortNumberAttributes() {
            var rowCount = $('#kt_repeater_1 [data-repeater-item]').length;
            var sortNumberInput = $('#kt_repeater_1 input[name*="[sort_num]"]');
            sortNumberInput.attr('max', rowCount);
            console.log('Max updated:', rowCount); // Add this line
        }

        jQuery(document).ready(function () {
            var systems = {!! json_encode($systems) !!}; // Pass the JSON data correctly

            $('#kt_repeater_1').repeater({
                initEmpty: false,
                show: function () {
                    $(this).slideDown();
                    updateSortNumberAttributes(); // Call the function here
                },
                hide: function (deleteElement) {
                    $(this).slideUp(deleteElement);
                    updateSortNumberAttributes(); // Call the function here as well
                }
            });

            $('#kt_repeater_1').on('change', '.system-dropdown', function () {
                var systemId = $(this).val();
                var mainHostInput = $(this).closest('.form-group').find('.main-host-input');
                var isSystem = $(this).find('option:selected').hasClass('system');
                if (isSystem) {
                    var mainHost = systems.find(system => system.id === parseInt(systemId)).main_host;
                    mainHostInput.val(mainHost).prop('disabled', true).data('main-host', mainHost); // Add data attribute
                } else {
                    mainHostInput.val('').prop('disabled', false).removeData('main-host'); // Remove data attribute
                }
                mainHostInput.removeClass('is-invalid'); // Remove invalid class if previously shown
            });


            $('#kt_repeater_1').on('click', '[data-repeater-create]', function () {
                updateSortNumberAttributes();
            });

            $('#kt_repeater_1').on('click', '[data-repeater-delete]', function () {
                $(this).closest('[data-repeater-item]').remove(); // Remove the deleted row
                updateSortNumberAttributes(); // Call the function to update the maximum value
            });

            updateSortNumberAttributes(); // Call the function initially
        });
    </script>

@endsection


@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('service-system-create')
                    <form method="POST" action="{{ route("service_systems.update", $service->id) }}"
                          enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="service">Selected Service<span class="text-danger">*</span></label>
                                <select id="service_id" name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}">
                                    <option value="">Select a Service</option>
                                        <option value="{{ $service->id }}" selected disabled>{{ $service->name }}</option>
                                </select>

                                @if($errors->has('service_id'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('service_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div id="kt_repeater_1">
                            <div data-repeater-list="systems">
                                @foreach($service->service_systems as $serviceSystem)
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-lg-3">
                                                <label for="system">Select a system<span class="text-danger">*</span></label>
                                                <select name="systems[][system_id]" class="system-dropdown form-control">
                                                    <option value="">Select a system or tier</option>
                                                    @foreach($systems as $system)
                                                    <option class="system" value="{{ $system->id }}" data-type="system" {{ isset($serviceSystem) && $serviceSystem->system_id == $system->id ? 'selected' : '' }}>
                                                            {{ $system->name }}
                                                        </option>
                                                    @endforeach
                                                    @foreach($tiers as $tier)
                                                        <option value="{{ $tier->id }}" data-type="tier" {{ isset($serviceSystem) && $serviceSystem->tier_id == $tier->id ? 'selected' : '' }}>
                                                            {{ $tier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="systems[][data_type]" class="system-data-type" value="">

                                            </div>

                                            <div class="col-lg-2">
                                                <label for="main_host">Main Host<span class="text-danger">*</span></label>
                                                <input name="systems[][main_host]" type="text"
                                                       class="main-host-input form-control"
                                                       value="{{ $serviceSystem->main_host }}" disabled>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="sort">Sort Number<span class="text-danger">*</span></label>
                                                <input name="systems[][sort_num]" type="number"
                                                       class="form-control" min="1"
                                                       value="{{ $serviceSystem->sort_num }}">
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="command">Command<span class="text-danger"> * <small>api get point</small></span></label>
                                                <input name="systems[][command]" type="text"
                                                       class="form-control" value="{{ $serviceSystem->command }}">
                                            </div>
                                            <div class="col-lg-1" style="margin-top: 27px;">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm font-weight-bolder btn-light-danger">
                                                    <i class="la la-trash-o"></i>
                                                </a>
                                            </div>

                                        </div>  <div class="form-group row">
                                            <label class="col-lg-2 col-form-label text-right"></label>
                                            <div class="col-lg-4">
                                                <a href="javascript:;" data-repeater-create class="btn btn-sm font-weight-bolder btn-light-primary">
                                                    <i class="la la-plus"></i>Add
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('service-system-create')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Edit</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
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



