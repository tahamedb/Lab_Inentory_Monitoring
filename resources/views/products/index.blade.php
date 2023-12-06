<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">


<div class="flex justify-end">
    <a href="javascript:history.go(-1)" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
            <path fill-rule="evenodd" d="M4.293 8.293a1 1 0 011.414 0L10 12.586l4.293-4.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
        Back
    </a>
</div>

<section>
    <h2 class="text-2xl font-semibold mt-6 mb-4">Add Product</h2>
    <form method="POST" action="{{ route('products.store') }}" class="bg-white p-6 rounded-lg shadow-md">
    @csrf
    <div class="flex flex-wrap -mx-2 mb-4">
        <div class="w-full px-2 mb-4 md:w-1/4 md:mb-0">
        <input type="text" placeholder="name" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300" required />

        </div>
        
        <div class="w-full px-2 mb-4 md:w-1/4 md:mb-0">
        <input type="number" placeholder="safety stock" name="safety_stock_level" id="safety_stock_level" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300" required />
        </div>
        <div class="w-full px-2 mb-4 md:w-1/4 md:mb-0">
        <input type="text" placeholder="Description" name="description" id="description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300" required />

        </div>
        <div class="w-full px-2 md:w-1/4">
            <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Add Product</button>
        </div>
    </div>
</form>
</section>
    <h1 class="text-3xl font-semibold mb-6">Product List</h1>
    
    <a href="{{ route('products.create') }}" class="mb-4 inline-block px-4 py-2 bg-green-500 text-white rounded-lg">Add New Product</a>
    
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="px-4 py-2 bg-gray-200">Name</th>
                <th class="px-4 py-2 bg-gray-200">Description</th>
                <th class="px-4 py-2 bg-gray-200">Current Stock</th>
                <th class="px-4 py-2 bg-gray-200">Safety Stock Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="px-4 py-2">{{ $product->name }}</td>
                    <td class="px-4 py-2">{{ $product->description }}</td>
                    <td class="px-4 py-2">{{ $product->current_stock }}</td>
                    <td class="px-4 py-2">{{ $product->safety_stock_level }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
