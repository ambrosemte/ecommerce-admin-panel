<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Shipping Rates List</h3>
    </div>

    {{-- Summary Cards --}}
    {{-- <div class="row mb-4">
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
    </div> --}}

    <h4 class="text-secondary mb-3">Shipping Rates Table</h4>
    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Shipping Method </th>
                <th>Shipping Zone </th>
                <th>Cost (NGN)</th>
                <th>Days Min</th>
                <th>Days Max</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shippingRates as $index => $rate)
                <tr>
                    <td>{{  $index + 1 }}</td>
                    <td>{{ $rate['method']['name'] }}</td>
                    <td>{{ $rate['zone']['name'] }}</td>
                    <td>{{ $rate['cost'] }}</td>
                    <td>{{ $rate['days_min'] }}</td>
                    <td>{{ $rate['days_max'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No shipping rate found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <nav>
            <ul class="pagination">
                @foreach ($links as $link)
                    <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ $link['url'] ? '' : 'disabled' }}">
                        <a class="page-link" role="button" wire:click.prevent="gotoPage('{{ $link['url'] }}')">
                            {!! $link['label'] !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>
