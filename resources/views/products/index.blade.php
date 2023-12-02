{{-- resources/views/products/index.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
</head>
<body>
    <h1>Product List</h1>
    <a href="{{ route('products.create') }}">Add New Product</a>
    <ul>
        @foreach ($products as $product)
            <li>{{ $product->name }} - {{ $product->description }} - {{$product->current_stock}}</li>
        @endforeach
    </ul>
</body>
</html>
