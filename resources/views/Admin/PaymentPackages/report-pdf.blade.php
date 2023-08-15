<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Subscriptions Report - PDF</title>
    <style>
        /* Add your custom styling for the PDF here */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .table-primary th {
            background-color: #007bff;
            color: #fff;
        }
        .text-center {
            text-align: center;
        }
        .strong {
            font-weight: bold;
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Subscriptions Report</h3>
    <table class="table table-separate table-head-custom table-checkable">
        <thead>
        <tr>
            <th>Record ID</th>
            <th>Company</th>
            <th>SubscriptionF Package</th>
            <th>Package Ticket</th>
            <th>Company Ticket</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($subscriptions['clients'] as $subscription)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $subscription['name'] ?? '' }}</td>
                <td>{{ $subscription['profile']['package_name'] ?? '' }}</td>
                <td>{{ $subscription['profile']['package_limit'] }}</td>
                <td>{{ ($subscription['profile']['package_limit']- $subscription['profile']['limit'])  }}</td>
                <td>{{ $subscription['subscriptions'][0]['paid_amount'] }}</td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr class="table-primary">
            <th scope="row">Total : </th>
            <td ><strong>  {{ $Company_num }}</strong></td>
            <td ><strong> </strong></td>
            <td ><strong> </strong></td>
            <td ><strong> </strong></td>
            <td ><strong>{{ $total_price }}</strong></td>
        </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
