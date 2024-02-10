@extends('admin.admin_dashboard')
@section('admin')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <div class="page-content">
        <div class="card">
            <div class="card-body">

                <h6 class="card-title">Add Product</h6>

                <form class="forms-sample" method="post" action="{{ route('products.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Product name</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="name" name="name" id="name"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300 text-black"
                                required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Safety Stock</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="safety stock" name="safety_stock_level"
                                id="safety_stock_level"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300 text-black"
                                required />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Description" name="description" id="description"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300 text-black" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="number" placeholder="Price" name="price" id="price"
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300 text-black" />
                        </div>
                    </div>
                    

                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                </form>
            </div>
        </div>

        <div class="mt-4"></div> <!-- Add a margin-top to create space between the form and the table -->

        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Products Table</h6>
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
                                                style="width: 176.344px;">Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Position: activate to sort column ascending"
                                                style="width: 279.164px;">Description</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 131.375px;">Current Stock</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 131.375px;">Price</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Office: activate to sort column ascending"
                                                style="width: 131.375px;">Expiry date</th>
                                            <th class="sorting" tabindex="0" aria-controls="dataTableExample"
                                                rowspan="1" colspan="1"
                                                aria-label="Age: activate to sort column ascending"
                                                style="width: 53.2578px;">Safety Stock</th>
                                            <th style="width: 53.2578px;">Transactions</th>
                                            <th style="width: 53.2578px;">Edit</th>
                                            <th style="width: 53.2578px;">Delete</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td class="px-4 py-2">{{ $product->name }}</td>
                                                <td class="px-4 py-2">{{ $product->description }}</td>
                                                <td class="px-4 py-2">{{ $product->current_stock }}</td>
                                                <td class="px-4 py-2">{{ $product->price }}</td>
                                                <td class="px-4 py-2">{{ $product->expiry_date }}</td>

                                                <td class="px-4 py-2">{{ $product->safety_stock_level }}</td>
                                                <td>
                                                    <a href="{{ route('transactions.index', ['product_name' => $product->name]) }}"
                                                        class="btn btn-primary">Transactions
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('products.delete', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
        </div>
    </div>
    

            <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
            <script>
                $(document).ready(function() {
                    $('#myTable').DataTable();

                });
            </script>
        @endsection
