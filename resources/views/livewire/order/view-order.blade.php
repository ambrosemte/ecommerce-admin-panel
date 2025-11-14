<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">View Order</h3>
    </div>

    <h4 class="text-secondary mb-3">Order Details</h4>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Order ID:</strong> {{ $order['id'] }}</p>
            <p><strong>Tracking ID:</strong> {{ $order['tracking_id'] }}</p>
            <p><strong>Store ID:</strong> {{ $order['store_id'] }}</p>
            <p><strong>Product:</strong> {{ $order['product']['name'] ?? 'N/A' }}</p>
            <p><strong>Quantity:</strong> {{ $order['quantity'] }}</p>
            <p><strong>Price:</strong> ₦{{ number_format($order['price'], 2) }}</p>
            <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($order['created_at'])->format('d M, Y H:i') }}</p>
            <p><strong>Progress Level:</strong> {{ $order['progress_level'] }}%</p>
        </div>
    </div>

    <h4 class="text-secondary mb-3">Shipping Details</h4>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Shipping Method:</strong> {{ $order['shipping_method']['name'] ?? 'N/A' }}</p>
            <p><strong>Shipping Rate:</strong> ₦{{ number_format($order['shipping_rate']['cost'] ?? 0, 2) }}</p>
            {{-- Estimated Delivery --}}
            @php
                $daysMax = $order['shipping_rate']['days_max'] ?? null;
                $createdAt = \Carbon\Carbon::parse($order['created_at']);
                $estimatedDate = $daysMax
                    ? $createdAt->copy()->addDays($daysMax)->format('d M, Y')
                    : null;
            @endphp

            <p>
                <strong>Estimated Delivery:</strong>
                {{ $estimatedDate ?? 'Unavailable' }}
            </p>
        </div>
    </div>

    <h4 class="text-secondary mb-3">Delivery Details</h4>
    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Country:</strong> {{ $order['delivery_detail']['country'] ?? 'N/A' }}</p>
            <p><strong>Sate:</strong> {{ $order['delivery_detail']['state'] ?? 'N/A' }}</p>
            <p><strong>City:</strong> {{ $order['delivery_detail']['city'] ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $order['delivery_detail']['street_address'] ?? 'N/A' }}</p>
            <p><strong>Postcode:</strong> {{ $order['delivery_detail']['zip_code'] ?? 'N/A' }}</p>
        </div>
    </div>

    <h4 class="text-secondary mb-3">Order Statuses</h4>
    <ul class="list-group mb-3">
        @foreach ($order['statuses'] as $status)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">{{ $status['status'] }}</div>
                    <small>{{ $status['description'] }}</small>
                </div>
                <span class="badge bg-primary rounded-pill">
                    {{ \Carbon\Carbon::parse($status['created_at'])->format('d M, Y H:i') }}
                </span>
            </li>
        @endforeach
    </ul>

    <h4 class="text-secondary mb-3">Latest Status</h4>
    <div class="alert alert-info">
        <strong>{{ $order['latest_status']['status'] ?? 'N/A' }}:</strong>
        {{ $order['latest_status']['description'] ?? '' }}
    </div>
</div>
