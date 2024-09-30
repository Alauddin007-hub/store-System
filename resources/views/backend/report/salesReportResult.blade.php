@extends ('backend.layouts.app')

@section('title', 'Sales Report')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Generate Reports</h3>
                        </div>

                        @if(!empty($sales))
                        <h2>Report Results</h2>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Total Price</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->customer->name }}</td>
                                        <td>{{ $sale->created_at }}</td>
                                        <td>{{ $sale->total_price }}</td>
                                        <td>
                                            <ul>
                                                @foreach($sale->details as $detail)
                                                <li>{{ $detail->book->book_bangla_name }} = {{ $detail->quantity }} x {{ $detail->price }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    <button class="print-button" onclick="window.print()">Print Report</button>
                    @else
                    <p>No records found.</p>
                    @endif
                </div>
                <!-- /.card -->
            </div>

        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection