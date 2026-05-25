<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Thank you for your order!</h2>
    <p>Hi {{ $order->user->name }},</p>
    <p>We've received your order <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong> and we're getting it ready.</p>
    
    <h3>Order Summary</h3>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr style="background-color: #f8f9fa;">
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Product</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Customization</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Price</th>
        </tr>
        @foreach($order->items as $item)
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ $item->product->name }}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($item->customization_json as $key => $value)
                        @if($value)
                            <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                        @endif
                    @endforeach
                </ul>
            </td>
            <td style="padding: 10px; border: 1px solid #ddd;">₹{{ number_format($item->calculated_price, 2) }}</td>
        </tr>
        @endforeach
        @if($order->gift_wrap)
        <tr>
            <td colspan="2" style="padding: 10px; border: 1px solid #ddd; text-align: right;">Premium Gift Wrap:</td>
            <td style="padding: 10px; border: 1px solid #ddd;">₹150.00</td>
        </tr>
        @endif
        <tr>
            <td colspan="2" style="padding: 10px; border: 1px solid #ddd; text-align: right;"><strong>Total:</strong></td>
            <td style="padding: 10px; border: 1px solid #ddd;"><strong>₹{{ number_format($order->total_amount, 2) }}</strong></td>
        </tr>
    </table>

    @if($order->delivery_date)
    <p><strong>Requested Delivery Date:</strong> {{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}</p>
    @endif
    
    @if($order->gift_message)
    <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #4a90e2; margin: 20px 0;">
        <h4 style="margin-top: 0;">Gift Message:</h4>
        <p style="font-style: italic;">"{{ $order->gift_message }}"</p>
    </div>
    @endif

    <p>We will notify you once your order has been shipped.</p>
    <br>
    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>
</html>
