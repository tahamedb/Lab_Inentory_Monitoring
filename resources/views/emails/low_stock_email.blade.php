<!DOCTYPE html>
<html>
<head>
    <title>Stock Alert</title>
</head>
<body>
    <h1>Stock Alert</h1>
    <p>The stock for the product <strong>{{ $productName }}</strong> is below the safety stock level.</p>
    <p> for more details please visit the <a href="{{ route('products.low-stock-alerts') }}">stock alerts page</a>.</p>
    <!-- You can add more product details here if passed from the Mailable -->
</body>
</html>
