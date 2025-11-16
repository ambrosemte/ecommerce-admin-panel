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
            <p><strong>Shipping Cost:</strong> ₦{{ number_format($order['shipping_cost'] ?? 0, 2) }}</p>
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

    <div class="d-flex justify-content-end gap-2 mt-3 flex-wrap">
        <button class="btn btn-success" wire:click="handleOrderAction('process')" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="handleOrderAction('process')">Process Order</span>
            <span wire:loading wire:target="handleOrderAction('process')">
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>
        <button class="btn btn-info text-white" wire:click="handleOrderAction('ship')" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="handleOrderAction('ship')">Mark as Shipped</span>
            <span wire:loading wire:target="handleOrderAction('ship')">
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>
        <button class="btn btn-warning text-white" wire:click="handleOrderAction('out_for_delivery')"
            wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="handleOrderAction('out_for_delivery')">Out for Delivery</span>
            <span wire:loading wire:target="handleOrderAction('out_for_delivery')">
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>
        <button class="btn btn-primary" wire:click="handleOrderAction('delivered')" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="handleOrderAction('delivered')">Mark as Delivered</span>
            <span wire:loading wire:target="handleOrderAction('delivered')">
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>

        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <span wire:loading.remove>More Actions</span>
                <span wire:loading wire:target="handleOrderAction"
                    x-show="$wire.currentAction == 'approve_refund' || $wire.currentAction == 'decline_refund'">
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Processing...
                </span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" wire:click="handleOrderAction('approve_refund')" role="button">Accept
                        Refund</a></li>
                <li><a class="dropdown-item" wire:click="handleOrderAction('decline_refund')" role="button">Reject
                        Refund</a></li>
            </ul>
        </div>
    </div>

</div>
