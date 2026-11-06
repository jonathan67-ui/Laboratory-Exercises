
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Supplier Performance Report</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h4>Performance Summary</h4>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Supplier</th>
                        <th>Total Orders</th>
                        <th>On-Time Rate</th>
                        <th>Average Delivery Days</th>
                        <th>Order Accuracy</th>
                        <th>Total Value</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report['supplier']->company_name }}</td>
                            <td>{{ $report['total_orders'] }}</td>
                            <td>{{ $report['on_time_rate'] }}%</td>
                            <td>{{ $report['average_delivery_days'] }}</td>
                            <td>{{ $report['accuracy'] }}%</td>
                            <td>{{ number_format($report['total_value'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <h4>Top Suppliers</h4>
                @foreach($topSuppliers as $report)
                    <p>{{ $report['supplier']->company_name }}
                        - {{ $report['on_time_rate'] }}%</p>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3">
                <h4>Bottom Suppliers</h4>
                @foreach($bottomSuppliers as $report)
                    <p>{{ $report['supplier']->company_name }}
                        - {{ $report['on_time_rate'] }}%</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
