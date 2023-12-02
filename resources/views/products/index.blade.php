<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-semibold mb-6">Product List</h1>
    
    <a href="{{ route('products.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg">Add New Product</a>
    
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
