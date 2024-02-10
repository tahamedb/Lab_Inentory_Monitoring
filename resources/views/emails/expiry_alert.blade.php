<!DOCTYPE html>
<html>
<head>
    <title>Expiry Alert</title>
</head>
<body>
    <h1>Expirty Alert</h1>
    @php
    $expiryDate = \Carbon\Carbon::parse($product->expiry_date);
    $days = $expiryDate->diffInDays(now());
    $productName=$product->name;
@endphp
    <p>The stock for the product <strong>{{ $productName }}</strong> is expiring in {{ $days }} days.</p>
    <p> for more details please visit the <a href="{{ route('products.low-stock-alerts') }}">stock alerts page</a>.</p>

    <!-- You can add more product details here if passed from the Mailable -->
</body>
</html>
