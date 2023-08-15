@extends('Dashboard.master')

@section('title')
    Companies
@endsection
@section('Page-title')
    Companies
@endsection
@section('js')
    <script>
        var avatar5 = new KTImageInput('kt_image_5');
    </script>
@endsection
@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('company-create')
                    <form method="POST" action="{{ route("companies.update", $company) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">

                            <div class="col-lg-12">
                                <div style="text-align: center">
                                    <div class="image-input image-input-empty image-input-outline" id="kt_image_5"
                                         style="background-image: url({{ $company->logo ? asset($company->logo) : asset('admin/assets/media/users/blank2.jpg') }})"
                                        ><div class="image-input-wrapper"></div>
                                        <label
                                            class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                            data-action="change" data-toggle="tooltip" title=""
                                            data-original-title="Company Logo">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input type="file" name="logo" accept=".png, .jpg, .jpeg"/>
                                            <input type="hidden" name="logo"/>
                                        </label>
                                        <span
                                            class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                            data-action="cancel" data-toggle="tooltip" title="Remove Logo">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
                                        <span
                                            class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                            data-action="remove" data-toggle="tooltip" title="Remove Company Logo">
															<i class="ki ki-bold-close icon-xs text-muted"></i>
														</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row pt-4">

                            <div class="col-lg-6">
                                <label for="name">Company Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                       name="name" id="name" value="{{ old('name', $company->name) }}"
                                       placeholder="Enter Company Name"/>
                                @if($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Company Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       name="email" id="email" value="{{ old('email', $company->email) }}"
                                       placeholder="Enter Company Email"/>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row pt-4">
                            <div class="col-lg-6">
                                <label for="address">Company Address<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-map-marker "></i></span>

                                    </div>
                                    <input type="text"
                                           class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                           name="address" id="address" value="{{ old('address', $company->address) }}"
                                           placeholder="Enter Company Address"/>


                                    @if($errors->has('address'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('address') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="website">Company Website<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
									<span class="input-group-text">
										<i class="flaticon2-website"></i>
                                    </span>
                                    </div>
                                    <input type="text"
                                           class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}"
                                           name="website" id="website" value="{{ old('website', $company->website) }}"
                                           placeholder="Enter Company Website"/>


                                    @if($errors->has('website'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pt-4">
                            <div class="col-lg-6">
                                <label for="phone">Company Phone<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-phone"></i></span>
                                    </div>
                                    <input type="text"
                                           class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                           name="phone" id="phone" value="{{ old('phone',  $company->phone) }}"
                                           placeholder="Enter Company Phone"/>
                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label>Company Active</label>
                                <div class="col-3">
                                    <span class="switch  switch-lg switch-icon">
                                        <label>
                                            <input type="checkbox" @if( $company->active == 1) checked
                                                   @else @endif name="active"/>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label>Company Description</label>
                                <textarea name="description"
                                          value="{{ old('description',  $company->description) }}"
                                          class="textarea form-control"
                                          style="width: 1000px; height: 150px">{{$company->description}}</textarea>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('company-edit')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Edit</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
                                    @can('company-list')
                                        <a type="button" href="{{route('companies.index')}}"
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
