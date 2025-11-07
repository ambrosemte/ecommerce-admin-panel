<div class="container mt-4">
    <h3>Order Details</h3>
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

    <h4>Order Statuses</h4>
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

    <h4>Latest Status</h4>
    <div class="alert alert-info">
        <strong>{{ $order['latest_status']['status'] ?? 'N/A' }}:</strong>
        {{ $order['latest_status']['description'] ?? '' }}
    </div>
</div>
