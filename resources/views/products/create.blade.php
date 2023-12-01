{{-- resources/views/products/create.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
</head>
<body>
    <h1>Add New Product</h1>
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="description">Description:</label>
        <input type="text" name="description" id="description"><br>

        <label for="safety_stock_level">Safety Stock Level:</label>
        <input type="number" name="safety_stock_level" id="safety_stock_level" required><br>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>
