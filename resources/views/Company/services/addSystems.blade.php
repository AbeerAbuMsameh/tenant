@extends('Dashboard.master')
@section('title')
    Add Systems
@endsection
@section('Page-title')
    Add Systems To Service
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
                    <form method="POST" action="{{ route('service_systems.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <label for="service">Select Service<span class="text-danger">*</span></label>
                                <select id="service_id" name="service_id" class="form-control {{ $errors->has('service_id') ? 'is-invalid' : '' }}">
                                    <option value="">Select a Service</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" @if($service->id == $service_id) selected @endif>{{ $service->name }}</option>
                                    @endforeach
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
                                <div data-repeater-item>
                                    <div class="form-group row">
                                        <div class="col-lg-3">
                                            <label for="system">Select a system<span class="text-danger">*</span></label>
                                            <select name="systems[][system_id]" class="system-dropdown form-control {{ $errors->has('systems.*.system_id') ? 'is-invalid' : '' }}">
                                                <option value="">Select a system or tier</option>
                                                @foreach($systems as $system)
                                                    <option class="system" value="{{ $system->id }}">{{ $system->name }}</option>
                                                @endforeach
                                                @foreach($tiers as $tier)
                                                    <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('systems.*.system_id'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('systems.*.system_id') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="main_host">Main Host<span class="text-danger">*</span></label>
                                            <input name="systems[][main_host]" type="text" class="main-host-input form-control {{ $errors->has('systems.*.main_host') ? 'is-invalid' : '' }}" disabled>
                                            @if($errors->has('systems.*.main_host'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('systems.*.main_host') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="sort">Sort Number<span class="text-danger">*</span></label>
                                            <input name="systems[][sort_num]" type="number" class="form-control {{ $errors->has('systems.*.sort_num') ? 'is-invalid' : '' }}" min="1">
                                            @if($errors->has('systems.*.sort_num'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('systems.*.sort_num') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="command">Command<span class="text-danger"> * <small>api get point</small></span></label>
                                            <input name="systems[][command]" type="text" class="form-control {{ $errors->has('systems.*.command') ? 'is-invalid' : '' }}">
                                            @if($errors->has('systems.*.command'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('systems.*.command') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-lg-1" style="margin-top: 27px;">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-sm font-weight-bolder btn-light-danger">
                                                <i class="la la-trash-o"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-right"></label>
                                <div class="col-lg-4">
                                    <a href="javascript:;" data-repeater-create class="btn btn-sm font-weight-bolder btn-light-primary">
                                        <i class="la la-plus"></i>Add
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('service-system-create')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Save</span>
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



