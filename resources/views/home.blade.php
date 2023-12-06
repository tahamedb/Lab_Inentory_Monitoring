<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">         
    <div class="bg-green-500 p-4">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="text-white text-2xl font-semibold">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 inline-block" /> <!-- Adjust size with h-20, h-24, etc. -->
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex space-x-4">
                <!-- <a href="{{ route('transactions.index') }}" class="bg-transparent-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Transactions</a>
                <a href="{{ route('products.index') }}" class="bg-transparent-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Products</a> -->
            </nav>
        </div>
    </div>
    <div class="container mx-auto bg-white rounded shadow p-6 m-4">
        <!-- Navigation Buttons -->
        <div class="flex justify-center space-x-4 mb-6">
            <a href="{{ route('transactions.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Transactions</a>
            <a href="{{ route('products.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Products</a>
        </div>

        <!-- Low Stock Alerts -->
        <section class="mb-6">
            <h2 class="border-b-2 border-gray-200 pb-2 mb-4">Low Stock Alerts</h2>
            <ul class="list-none">
                @foreach ($lowStockProducts as $product)
                    <li class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        {{ $product->name }} - Current Stock: {{ $product->current_stock }} - Safety stock: {{ $product->safety_stock_level }}
                    </li>
                @endforeach
            </ul>
        </section>
        
        <!-- Recent Transactions -->
        <section>
            <h2 class="border-b-2 border-gray-200 pb-2 mb-4">Recent Transactions</h2>
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Product</th>
                        <th class="px-4 py-2 border">Type</th>
                        <th class="px-4 py-2 border">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentTransactions as $transaction)
                        <tr class="bg-white">
                            <td class="border px-4 py-2">{{ $transaction->created_at->toDateString() }}</td>
                            <td class="border px-4 py-2">{{ $transaction->product->name }}</td>
                            <td class="border px-4 py-2">{{ $transaction->type }}</td>
                            <td class="border px-4 py-2">{{ $transaction->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
