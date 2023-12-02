<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-semibold mb-6">Add New Product</h1>

    <form method="POST" action="{{ route('products.store') }}" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-600">Name:</label>
            <input type="text" name="name" id="name" class="px-4 py-2 rounded-lg border w-full" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-600">Description:</label>
            <input type="text" name="description" id="description" class="px-4 py-2 rounded-lg border w-full">
        </div>

        <div class="mb-4">
            <label for="safety_stock_level" class="block text-gray-600">Safety Stock Level:</label>
            <input type="number" name="safety_stock_level" id="safety_stock_level" class="px-4 py-2 rounded-lg border w-full" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Add Product</button>
    </form>
</body>
</html>
