<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Stores List</h3>
    </div>

    <h4 class="text-secondary mb-3">Summary Stats</h4>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Stores</h5>
                    <h3 class="fw-bold">{{ $totalStores }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success text-center">
                <div class="card-body">
                    <h5 class="card-title">Active Stores</h5>
                    <h3 class="fw-bold">{{ $activeStores }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-secondary text-center">
                <div class="card-body">
                    <h5 class="card-title">Inactive Stores</h5>
                    <h3 class="fw-bold">{{ $totalStores - $activeStores }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h4 class="text-secondary mb-3">Stores table</h4>
    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Followers</th>
                <th>Product Count</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stores as $index => $store)
                <tr>
                    <td>{{  $index + 1 }}</td>
                    <td>{{ $store['name'] }}</td>
                    <td>{{ $store['followers_count'] }}</td>
                    <td>{{ count($store['products']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No stores found.</td>
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
