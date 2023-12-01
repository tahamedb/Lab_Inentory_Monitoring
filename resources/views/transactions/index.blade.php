{{-- resources/views/transactions/index.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Transactions</title>
</head>
<body>
    <h1>Transactions</h1>

    {{-- Filter Form --}}
    <form action="{{ route('transactions.index') }}" method="GET">
        <input type="text" name="product_name" placeholder="Filter by product name">
        <input type="text" name="user_name" placeholder="Filter by user name">
        <button type="submit">Filter</button>
    </form>

    {{-- Transaction List --}}
    <ul>
        @foreach ($transactions as $transaction)
            <li>{{ $transaction->product->name }} - {{ $transaction->user->name }} - {{ $transaction->type }}</li>
        @endforeach
    </ul>

    {{-- Add Transaction Form --}}
    <h2>Add Transaction</h2>
    <form method="POST" action="{{ route('transactions.store') }}">
        @csrf
        <select name="product_name">
            @foreach ($products as $product)
                <option value="{{ $product->name }}">{{ $product->name }}</option>
            @endforeach
        </select>
        <input type="number" name="quantity" required>
        <select name="type">
            <option value="entry">Entry</option>
            <option value="exit">Exit</option>
        </select>
        <textarea name="remarks" placeholder="Description"></textarea>
        <button type="submit">Add Transaction</button>
    </form>
</body>
</html>
