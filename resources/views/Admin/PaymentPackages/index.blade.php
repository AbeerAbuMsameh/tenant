@extends('Dashboard.master')
@section('title')
    Companies
@endsection
@section('subTitle')
    Companies
@endsection

@section('Page-title')
    Subscription Packages
@endsection

@section('content')

    <div class="container">
        @can('payment-list')
            <div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-chart text-primary"></i>
                        </span>
                        <h3 class="card-label">Basic Subscription Packages</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center my-20">
                        <!--begin: Pricing-->
                        @foreach ($packages['packages'] as $package)
                            <div class="col-md-4 col-xxl-3 border-x-0 border-x-md border-y border-y-md-0">
                                <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                                    <!--begin::Icon-->
                                    <div class="d-flex flex-center position-relative mb-25">
                                        <span class="svg svg-fill-primary opacity-4 position-absolute">
                                            <svg width="175" height="200">
                                                <polyline
                                                    points="87,0 174,50 174,150 87,200 0,150 0,50 87,0"></polyline>
                                            </svg>
                                        </span>
                                        <span class="svg-icon svg-icon-5x svg-icon-primary">
                                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\Shopping\Money.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                 height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none"
                                                   fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <path
                                                        d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z"
                                                        fill="#000000" opacity="0.3"
                                                        transform="translate(11.500000, 12.000000) rotate(-345.000000) translate(-11.500000, -12.000000) "/>
                                                    <path
                                                        d="M2,6 L21,6 C21.5522847,6 22,6.44771525 22,7 L22,17 C22,17.5522847 21.5522847,18 21,18 L2,18 C1.44771525,18 1,17.5522847 1,17 L1,7 C1,6.44771525 1.44771525,6 2,6 Z M11.5,16 C13.709139,16 15.5,14.209139 15.5,12 C15.5,9.790861 13.709139,8 11.5,8 C9.290861,8 7.5,9.790861 7.5,12 C7.5,14.209139 9.290861,16 11.5,16 Z M11.5,14 C12.6045695,14 13.5,13.1045695 13.5,12 C13.5,10.8954305 12.6045695,10 11.5,10 C10.3954305,10 9.5,10.8954305 9.5,12 C9.5,13.1045695 10.3954305,14 11.5,14 Z"
                                                        fill="#000000"/>
                                                </g>
                                            </svg><!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <!--end::Icon-->
                                    <!--begin::Content-->
                                    <span class="font-size-h1 d-block font-weight-boldest text-dark-75 py-2">{{$package['price']}}
                                        <sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
                                    <h4 class="font-size-h6 d-block font-weight-bold mb-7 text-dark-50">
                                        {{$package['name']}}
                                    </h4>
                                    <p class="mb-15 d-flex flex-column">
                                        <span> {{$package['limit']}}Ticket</span>
                                        <br>
                                        <span> {{$package['description']}}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endcan
    </div>

@endsection

