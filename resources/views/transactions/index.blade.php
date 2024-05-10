@extends('admin.admin_dashboard')
@section('admin')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <style type="text/css">
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fcfcfc;
            line-height: 1;
        }

        .disabled-link {
            pointer-events: none;
            color: #ccc;
            /* Gray out the link */
            cursor: default;
        }

        .select2-container--focus.select2-container--default .select2-selection--single,
        .select2-container--focus.select2-container--default .select2-selection--multiple {
            border: 1px solid #243866;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #b92626;
        }

        .select2-dropdown {
            background-color: #0c1428;

        }

        .select2-container--default .select2-selection--single {
            background-color: #0c1428;

        }
    </style>


    <div class="page-content">
        <div class="card">
            <div class="card-body">

                <h6 class="card-title">Add Transaction</h6>

                <form class="forms-sample" method="POST" action="{{ route('transactions.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Product name</label>
                        <div class="col-sm-9">
                            <select name="product_name" id="product_name" class="form-control">
                                @foreach ($products as $product)
                                    <option value="{{ $product->name }}"
                                        {{ request('product_name') == $product->name ? 'selected' : '' }}>
                                        {{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="quantity" class="col-sm-3 col-form-label">Quantity</label>
                        <div class="col-sm-9">
                            <input type="number" name="quantity" id="quantity" class="form-control" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="type" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                            <select name="type" id="type" class="form-control">
                                <option value="">Select Type</option>
                                <option value="entry">Entry</option>
                                <option value="exit">Exit</option>
                            </select>
                        </div>
                    </div>

                    <!-- Expiry Date, initially hidden -->
                    <div class="row mb-3" id="expiryDateContainer" style="display: none;">
                        <label for="expiry_date" class="col-sm-3 col-form-label">Expiry date</label>
                        <div class="col-sm-9">
                            <input type="date" name="expiry_date" id="expiry_date" class="form-control" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">Remarks</label>
                        <div class="col-sm-9">
                            <input type="text" name="remarks" id="description" class="form-control" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <div class="mt-4"></div> <!-- Add a margin-top to create space between the form and the table -->


        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Transactions Table</h6>
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
                                                style="width: 176.344px;">Date</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 279.164px;">Product name</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 131.375px;"> Type</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Age: activate to sort column ascending"
                                                style="width: 53.2578px;">Quantity</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Age: activate to sort column ascending"
                                                style="width: 53.2578px;">Remarks</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Age: activate to sort column ascending"
                                                style="width: 53.2578px;">Username</th>
                                            <th style="width: 53.2578px;">Edit</th>
                                            <th style="width: 53.2578px;">Delete</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td class="px-4 py-2">{{ $transaction->created_at->toDateString() }}</td>
                                                <td class="px-4 py-2">{{ $transaction->product->name }}</td>
                                                <td class="px-4 py-2">{{ $transaction->type }}</td>
                                                <td class="px-4 py-2">{{ $transaction->quantity }}</td>
                                                <td class="px-4 py-2">{{ $transaction->remarks }}</td>
                                                <td class="px-4 py-2">{{ $transaction->user_name }}</td>
                                                <td>
                                                    <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                        class="btn btn-primary btn-sm {{ Auth::user()->id == 1 ? '' : 'disabled-link' }}">
                                                        Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('transactions.delete', $transaction->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            {{ Auth::user()->id == 1 ? '' : 'disabled' }}>Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-5">

                            </div>
                        </div>

                    </div>
                    <div>

                    </div>


                </div>
            </div>
            <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" defer></script>

            <script>
                @php
                    $productName = request()->get('product_name');
                @endphp
                $(document).ready(function() {
                    $('#myTable').DataTable();
                    var productName = "{{ $productName }}";
                    if (productName) {
                        $('#myTable').DataTable().search(productName).draw(); // Apply the filter
                    }
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var transactionType = document.getElementById('type'); // Corrected ID
                    var expiryDateContainer = document.getElementById('expiryDateContainer');

                    // Hide expiry date by default if the selected type is not 'entry'
                    if (transactionType.value !== 'entry') {
                        expiryDateContainer.style.display = 'none';
                    }

                    transactionType.addEventListener('change', function() {
                        // Show or hide the expiry date field based on the type of transaction
                        expiryDateContainer.style.display = this.value === 'entry' ? 'flex' : 'none';
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('#product_name').select2();
                    // $('#select2-'+myID+'-container').parent().css('background-color', 'red');

                });
            </script>
        @endsection
