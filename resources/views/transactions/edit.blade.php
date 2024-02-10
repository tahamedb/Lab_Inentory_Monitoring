@extends('admin.admin_dashboard')
@section('admin')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">

   <div class="page-content"> 
    <div class="card">
        <div class="card-body">


<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-semibold mb-4">Edit Transaction</h1>
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="max-w-md mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="product_name" class="block text-sm font-medium text-white-700 mb-2">Product Name</label>
            <select name="product_name" id="product_name" class="px-4 py-2 rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500 text-black " value="{{$transaction->product->name}}" required>
                @foreach ($products as $product)
                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-white-700 mb-2">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="px-4 py-2 rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500 text-black"  value="{{$transaction->quantity}}" required />
        </div>
        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-white-700 mb-2">Type</label>
            <select name="type" id="type" class="px-4 py-2  rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500 text-black" value="{{$transaction->type}}" required>
                <option value="">Select Type</option>
                <option value="entry">Entry</option>
                <option value="exit">Exit</option>
            </select>

        </div>
        <!-- Expiry Date, initially hidden -->
        <div class="row mb-3" id="expiryDateContainer" style="display: none;">
            <label for="expiry_date" class="col-sm-3 col-form-label">Expiry date</label>
            <div class="col-sm-9">
                <input type="date" name="expiry_date" id="expiry_date" class="form-control" />
            </div>
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-white-700 mb-2">Remarks</label>
            <input type="text" name="remarks" id="remarks" class="px-4 py-2 rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500 text-black"  value="{{$transaction->remarks}}" required />
        </div>
        </div>
        <div class="mb-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ">
                Update Transaction
            </button>
        </div>
    </form>
</div>
</div>
</div>
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
    
@endsection