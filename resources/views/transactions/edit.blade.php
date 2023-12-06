
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
    <a href="javascript:history.go(-1)" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
            <path fill-rule="evenodd" d="M4.293 8.293a1 1 0 011.414 0L10 12.586l4.293-4.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
        Back
    </a>
</div>

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-semibold mb-4">Edit Transaction</h1>
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="max-w-md mx-auto">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="product_name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
            <select name="product_name" id="product_name" class="px-4 py-2 rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500">
                @foreach ($products as $product)
                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="px-4 py-2 rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500" required />
        </div>
        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
            <select name="type" id="type" class="px-4 py-2 rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500">
                <option value="entry">Entry</option>
                <option value="exit">Exit</option>
            </select>
            <div class="mb-4">
            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
            <input type="text" name="remarks" id="remarks" class="px-4 py-2 rounded-lg border w-full focus:ring-blue-500 focus:border-blue-500"  />
        </div>
        </div>
        <div class="mb-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Transaction
            </button>
        </div>
    </form>
</div>
