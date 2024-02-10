@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Low Stock Alerts</h6>
                <div class="table-responsive">
                    <div id="dataTableExample_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">


                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table data-order="[]" id="myTable" class="table dataTable no-footer"
                                    aria-describedby="dataTableExample_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 176.344px;">Product name</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 279.164px;">Alert Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 131.375px;">Current Stock</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Age: activate to sort column ascending"
                                                style="width: 53.2578px;">Safety Stock</th>
                                            <th style="width: 53.2578px;">Transactions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($StockAlerts as $alert)
                                            <tr>
                                                @php
                                                    $entries = $alert->product->transactions->where('type', 'entry')->sum('quantity');
                                                    $exits = $alert->product->transactions->where('type', 'exit')->sum('quantity');
                                                    $current_stock = $entries - $exits; // Calculate current stock
                                                @endphp
                                                <td>{{ $alert->product->name }}</td>
                                                <td>{{ $alert->created_at->format('Y-m-d H:i') }} </td>
                                                <td>{{ $current_stock }}</td>

                                                <td>{{ $alert->product->safety_stock_level }}</td>
                                                <td>
                                                    <a href="{{ route('transactions.index', ['product_name' => $alert->product->name]) }}"
                                                        class="btn btn-danger">Add Stock</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>


                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   <br>
   

        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Expiring Soon</h6>
                <div class="table-responsive">
                    <div id="dataTableExample_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <div class="row">


                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table data-order="[]" id="myTable" class="table dataTable no-footer"
                                    aria-describedby="dataTableExample_info">
                                    <thead>
                                        <tr>
                                            <th class="sorting sorting_asc" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending"
                                                style="width: 176.344px;">Product name</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 279.164px;">Alert Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 131.375px;">Expiry Date </th>

                                            <th style="width: 53.2578px;">Transactions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ExpiryAlerts as $alert)
                                            <tr>

                                                <td>{{ $alert->product->name }}</td>
                                                <td>{{ $alert->created_at->format('Y-m-d H:i') }} </td>
                                                <td>{{ $alert->product->expiry_date }}</td>

                                                <td>
                                                    <a href="{{ route('transactions.index', ['product_name' => $alert->product->name]) }}"
                                                        class="btn btn-danger">Add Stock</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                                 
 @endsection
