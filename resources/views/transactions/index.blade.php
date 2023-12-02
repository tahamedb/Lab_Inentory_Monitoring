<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css">
    <style>
        /* Add Transaction Form */
        .form-add-transaction form {
            display: flex; /* Using flexbox to align form items */
            justify-content: center; /* Center form items horizontally */
            align-items: center; /* Center form items vertically */
            gap: 10px; /* Space between form items */
            margin: auto; /* Center the form in the section */
        }

        .form-add-transaction select,
        .form-add-transaction input[type="number"] {
            flex: 1; /* Allow the select and input to grow and take up available space */
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            min-width: 0; /* Overcome flexbox minimum size issue */
        }

        .form-add-transaction input[type="number"] {
            -webkit-appearance: none; /* Removes default number input spinners */
            -moz-appearance: textfield;
        }

        .form-add-transaction button {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            white-space: nowrap; /* Prevent text wrapping inside the button */
        }

        .form-add-transaction button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-semibold mb-6">Transactions</h1>


    <section class="form-add-transaction">
    <h2 class="text-2xl font-semibold mt-6">Add Transaction</h2>
    <form method="POST" action="{{ route('transactions.store') }}" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <select name="product_name" id="product_name" class="px-4 py-2 rounded-lg border w-full">
                @foreach ($products as $product)
                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <input type="number" name="quantity" id="quantity" class="px-4 py-2 rounded-lg border w-full" required />
        </div>
        <div class="mb-4">
            <select name="type" id="type" class="px-4 py-2 rounded-lg border w-full">
                <option value="entry">Entry</option>
                <option value="exit">Exit</option>
            </select>
        </div>
        <div class="mb-4">
            <textarea name="remarks" id="remarks" class="px-4 py-2 rounded-lg border w-full" placeholder="Description"></textarea>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Add Transaction</button>
    </form>
    </section>

<div class="px-4 py-2">


</div>
    {{-- Filter Form --}}
    <form action="{{ route('transactions.index') }}" method="GET" class="mb-6">
        <div class="flex space-x-4">
            <input type="text" name="product_name" placeholder="Filter by product name" class="px-4 py-2 rounded-lg border" />
            <input type="text" name="user_name" placeholder="Filter by user name" class="px-4 py-2 rounded-lg border" />
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Filter</button>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

   
</body>
</html>
