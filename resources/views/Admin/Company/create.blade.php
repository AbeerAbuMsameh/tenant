@extends('Dashboard.master')

@section('title')
    Companies
@endsection
@section('Page-title')
    Companies
@endsection
@section('js')
    <script>
        var avatar1 = new KTImageInput('kt_image_5');
    </script>

@endsection
@section('content')
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                @can('company-create')
                    <form method="POST" action="{{ route("companies.store") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">

                            <div class="col-lg-12">
                                <div style="text-align: center">
                                    <div class="image-input image-input-empty image-input-outline" id="kt_image_5"
                                         style="background-image: url({{asset('admin/assets/media/users/blank2.jpg')}})">
                                        <div class="image-input-wrapper"></div>
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

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           name="name" id="name" value="{{ old('name', '') }}"
                                           placeholder="Enter Company Name" required/>

                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                    @endif
                                </div>


                            </div>

                            <div class="col-lg-6">
                                <label for="email">Company Email<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-new-email"></i></span>
                                    </div>  <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                       name="email" id="email" required value="{{ old('email', '') }}"
                                       placeholder="Enter Company Email"/>
                                @if($errors->has('email'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row pt-4">
                            <div class="col-lg-6">
                                <label for="address">Company Address<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="la la-map-marker "></i></span>
                                    </div>
                                    <input type="text" required
                                           class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                           name="address" id="address" value="{{ old('address', '') }}"
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
                                           name="website" id="website" value="{{ old('website', '') }}"
                                           placeholder="Enter Company website" required/>

                                    @if($errors->has('website'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('website') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="form-group row pt-4">
                            <div class="col-lg-6">
                                <label for="payment_package">Subscription Package<span class="text-danger">*</span></label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon-price-tag"></i></span>
                                    </div>
                                    <select class="form-control {{ $errors->has('payment_package') ? 'is-invalid' : '' }}" name="payment_package" id="payment_package" required>
                                        <option value="">Select Subscription Package</option>
                                        @foreach($payment_packages as $payment_package)
                                            <option value="{{ $payment_package['id'] }}">{{ $payment_package['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('payment_package'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('payment_package') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="payment_method">Payment Method<span class="text-danger">*</span></label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon-coins"></i></span>
                                    </div>
                                    <select class="form-control {{ $errors->has('payment_method') ? 'is-invalid' : '' }}" name="payment_method" id="payment_package" required>
                                        <option value="Visa">Select Payment Method</option>
                                        <option value="Visa">Visa</option>
                                        <option value="MasterCard">MasterCard</option>
                                        <option value="PayPal">PayPal</option>
                                    </select>
                                    @if($errors->has('payment_method'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('payment_method') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-4">
                                <label for="phone">Company Phone<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-phone"></i></span>
                                    </div>
                                    <input type="text" required
                                           class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                           name="phone" id="phone" value="{{ old('phone', '') }}"
                                           placeholder="Enter Company Phone"/>

                                    @if($errors->has('phone'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('phone') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <label for="promo_code">Promo Code</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="flaticon2-file"></i></span>
                                    </div>
                                    <input type="text"
                                           class="form-control {{ $errors->has('promo_code') ? 'is-invalid' : '' }}"
                                           name="promo_code" id="promo_code" value="{{ old('promo_code', '') }}"
                                           placeholder="Enter Promo Code"/>

                                    @if($errors->has('promo_code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('promo_code') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label>Company Active</label>
                                <div class="col-3">
                                    <span class="switch  switch-lg switch-icon">
                                        <label>
                                            <input type="checkbox" checked="checked" name="active"/>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row pt-4">
                            <div class="col-lg-12">
                                <label>Company Description</label>
                                <textarea name="description" class="textarea form-control "
                                          style="width: 1000px; height: 150px"
                                          value="{{ old('description', '') }}"></textarea></div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    @can('company-create')
                                        <button type="submit" class="btn btn-primary">
                                            <span class="indicator-label">Save</span>
                                        </button>
                                    @endcan
                                    <input type="reset" value="Reset" class="btn btn-white me-3">
                                    <a type="button" href="{{route('companies.index')}}"
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
