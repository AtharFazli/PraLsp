<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
</head>
<body>
    <h1>Order Receipt</h1>
    <p>Payment Method: {{ $orderData['paymentMethod'] }}</p>
    <p>Discount: {{ $orderData['discount'] }}</p>

    <h2>Order Details</h2>
    <ul>
        @foreach($orderData['cart'] as $item)
            <li>{{ $item['name'] }} - {{ $item['price'] }} - {{ $item['quantity'] }} pcs</li>
        @endforeach
    </ul>

    <p>Total Price: {{ $orderData['total'] }}</p>
    <p>Discounted Total: {{ $discountedTotal }}</p>
</body>
</html>
