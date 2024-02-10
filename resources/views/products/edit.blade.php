@extends('admin.admin_dashboard')
@section('admin')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">

   <div class="page-content"> 
    <div class="card">
        <div class="card-body">

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-semibold mb-4">Edit product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="max-w-md mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="product_name" class="block text-sm font-medium text-black-700 mb-2">Product Name</label>
            <input type="text" name="name" id="name" class="px-4 py-2 rounded-lg border w-full focus:ring-black-500 focus:border-black-500 text-black" value="{{ $product->name }}" />
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-black-700 mb-2">Safety Stock</label>
            <input type="number" name="safety_stock_level" id="quantity" class="px-4 py-2 rounded-lg border w-full focus:ring-black-500 focus:border-black-500 text-black" value="{{ $product->safety_stock_level }}"/>
        </div>
        <div class="mb-4">
            <label for="remarks" class="block text-sm font-medium text-black-700 mb-2">Description</label>
            <input type="text" name="description" id="remarks" class="px-4 py-2 rounded-lg border w-full focus:ring-black-500 focus:border-black-500 text-black" value="{{ $product->description }}"  />
        </div>
        
        <div class="mb-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update product
            </button>
        </div>
    </form>
</div>
    </div>
   </div>
</div>
@endsection