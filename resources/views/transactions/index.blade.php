

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 p-6">

<div class="flex justify-end mb-6">
    <a href="javascript:history.go(-1)" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">
        Back
    </a>
</div>

<h1 class="text-3xl font-semibold mb-6">Transactions</h1>
<section>
    <h2 class="text-2xl font-semibold mt-6 mb-4">Add Transaction</h2>
    <form method="POST" action="{{ route('transactions.store') }}" class="bg-white p-6 rounded-lg shadow-md">
    @csrf
    <div class="flex flex-wrap -mx-2 mb-4">
        <div class="w-full px-2 mb-4 md:w-1/4 md:mb-0">
            <select name="product_name" id="product_name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300">
            @foreach ($products as $product)
                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach            </select>
        </div>
        <div class="w-full px-2 mb-4 md:w-1/4 md:mb-0">
            <input type="number" name="quantity" id="quantity" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300" required />
        </div>
        <div class="w-full px-2 mb-4 md:w-1/4 md:mb-0">
            <select name="type" id="type" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300">
            <option value="entry">Entry</option>
                <option value="exit">Exit</option>
                        </select>
        </div>
        <div class="w-full px-2 md:w-1/4">
            <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Add Transaction</button>
        </div>
    </div>
</form>
</section>
<div class="px-4 py-4">
    
</div>
<!-- Filter Form -->
<form action="{{ route('transactions.index') }}" method="GET" class="mb-6">
    <div class="flex space-x-4">
        <input type="text" name="product_name" placeholder="Filter by product name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300" />
        <input type="text" name="user_name" placeholder="Filter by user name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:border-blue-300" />
        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Filter</button>
    </div>
</form>

<section class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Recent Transactions</h2>
    <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-200">Date</th>
                    <th class="px-4 py-2 bg-gray-200">Product</th>
                    <th class="px-4 py-2 bg-gray-200">Type</th>
                    <th class="px-4 py-2 bg-gray-200">Quantity</th>
                    <th class="px-4 py-2 bg-gray-200">Remarks</th>
                    <th class="px-4 py-2 bg-gray-200">Username</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($transactions as $transaction) 
                <!-- Placeholder for server-side rendered content -->
                <tr>
                    <td class="px-4 py-2">{{ $transaction->created_at->toDateString() }}</td>
                    <td class="px-4 py-2">{{ $transaction->product->name }}</td>
                    <td class="px-4 py-2">{{ $transaction->type }}</td>
                    <td class="px-4 py-2">{{ $transaction->quantity }}</td>
                    <td class="px-4 py-2">{{ $transaction->remarks }}</td>
                    <td class="px-4 py-2">{{ $transaction->user_name }}</td>
                    <td class="px-4 py-2">
                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="inline-block px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 hover:text-gray-100 transition duration-300 ease-in-out">Edit</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>    
</section>

</body>
</html>
