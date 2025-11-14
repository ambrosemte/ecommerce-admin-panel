<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Shipping Methods List</h3>
    </div>

    <h4 class="text-secondary mb-3">Summary Stats</h4>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Shipping Method</h5>
                    <h3 class="fw-bold">{{ $totalMethods }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success text-center">
                <div class="card-body">
                    <h5 class="card-title">Active Shipping Method</h5>
                    <h3 class="fw-bold">{{ $activeMethods }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-secondary text-center">
                <div class="card-body">
                    <h5 class="card-title">Inactive Shipping Method</h5>
                    <h3 class="fw-bold">{{ $totalMethods - $activeMethods }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Shipping Method Table --}}
    <h4 class="mb-3">Shipping Method List</h4>

    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Enabled</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shippingMethods as $index => $method)
                <tr>
                    <td>{{  $index + 1 }}</td>
                    <td>{{ $method['name'] }}</td>
                    <td>{{ $method['is_active'] ? '✅' : '❌' }}</td>
                    <td>
                        <button class="btn btn-primary" wire:click="activateShippingMethod('{{ $method['id'] }}')">
                            <span>Activate</span>
                        </button>
                        <button class="btn btn-secondary" wire:click="deactivateShippingMethod('{{ $method['id'] }}')">
                            <span>Deactivate</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No shipping method found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
