<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">View Shipping Rate</h3>
    </div>

    {{-- Shipping Rates Table --}}
    <h4 class="text-secondary mb-3">Shippping Rates Table</h4>
    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Method </th>
                <th>Zone </th>
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
