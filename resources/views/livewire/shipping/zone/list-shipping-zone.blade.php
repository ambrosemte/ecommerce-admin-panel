<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Shipping Zones List</h3>
    </div>

    <h4 class="text-secondary mb-3">Summary Stats</h4>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Shipping Zone</h5>
                    <h3 class="fw-bold">{{ $totalZones }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success text-center">
                <div class="card-body">
                    <h5 class="card-title">Active Shipping Zone</h5>
                    <h3 class="fw-bold">{{ $activeZones }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-secondary text-center">
                <div class="card-body">
                    <h5 class="card-title">Inactive Shipping Zone</h5>
                    <h3 class="fw-bold">{{ $totalZones - $activeZones }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h4 class="text-secondary mb-3">Shipping Zones Table</h4>
    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Enabled</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shippingZones as $index => $zone)
                <tr>
                    <td>{{  $index + 1 }}</td>
                    <td>{{ $zone['name'] }}</td>
                    <td>{{ $zone['country'] }}</td>
                    <td>{{ $zone['state'] }}</td>
                    <td>{{ $zone['city'] }}</td>
                    <td>{{ $zone['is_active'] ? '✅' : '❌' }}</td>
                    <td>
                        <button class="btn btn-primary" wire:click="viewShippingRate('{{ $zone['id'] }}')">
                            <span>View Shipping Rates</span>
                        </button>
                        <button class="btn btn-secondary"
                            wire:click="createShippingRate('{{ $zone['id'] }}', '{{ $zone['name'] }}')">
                            <span>Create Shipping Rate</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No shipping zone found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <nav>
            <ul class="pagination">
                @foreach ($links as $link)
                    <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ $link['url'] ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $link['url'] ?? '#' }}"
                            wire:click.prevent="gotoPage('{{ $link['url'] }}')">
                            {!! $link['label'] !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
