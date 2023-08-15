@extends('Dashboard.master')
@section('title')
    Subscriptions Report
@endsection
@section('subTitle')
    Subscriptions Report
@endsection

@section('Page-title')
    Subscriptions Report
@endsection

@section('js')
@endsection
@section('content')

    <div class="container">
        @can('payment-list')
            <div class="card card-custom">

                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Table of Subscriptions
                        </h3>
                    </div>
                        <div class="card-toolbar">
                            <a href="{{ route('export.pdf') }}"
                               class="btn btn-sm btn-light-primary er fs-6 px-8 py-4"  target="_blank">
                                <i class="la la-print"></i> Export PDF
                            </a>
                        </div>
                </div>


                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                        <thead>
                        <tr>
                            <th>Record ID</th>
                            <th>Company</th>
                            <th>Subscription Package</th>
                            <th>Package Ticket</th>
                            <th>Company Ticket</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($subscriptions['clients'] as $subscription)
                            <tr >
                                <td> {{ $loop->iteration }}</td>
                                <td>{{ $subscription['name']  ?? '' }}</td>
                                <td>{{ $subscription['profile']['package_name'] ?? '' }}</td>
                                <td>{{ $subscription['profile']['package_limit'] }}</td>
                                <td>{{ ($subscription['profile']['package_limit']- $subscription['profile']['limit'])  }}</td>
                                <td>{{ $subscription['subscriptions'][0]['paid_amount']  }}</td>

                            </tr>
                        @endforeach

                        </tbody>
                        <tfoot>
                        <tr class="table-primary">
                            <th scope="row">Total : </th>
                            <td ><strong>  {{ $Company_num }}</strong></td>
                            <th scope="row"></th>

                            <td ><strong> </strong></td>
                            <td ><strong> </strong></td>
                            <td ><strong>{{ $total_price }}</strong></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        @endcan
    </div>

@endsection

