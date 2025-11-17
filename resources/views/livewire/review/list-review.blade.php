<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Reviews List</h3>
    </div>

    <h4 class="text-secondary mb-3">Summary Stats</h4>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Reviews</h5>
                    <h3 class="fw-bold">{{ $totalReviews }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success text-center">
                <div class="card-body">
                    <h5 class="card-title">Approved Reviews</h5>
                    <h3 class="fw-bold">{{ $approvedReviews }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-secondary text-center">
                <div class="card-body">
                    <h5 class="card-title">Not Approved Reviews</h5>
                    <h3 class="fw-bold">{{ $totalReviews - $approvedReviews}}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders Table --}}
    <h4 class="mb-3">Reviews Table</h4>

    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Message</th>
                <th>Rating</th>
                <th>Approved</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reviews as $index => $review)
                <tr>
                    <td>{{  $index + 1 }}</td>
                    <td>{{ $review['message'] }}</td>
                    <td>{{ $review['rating'] }}</td>
                    <td>{{ $review['approved'] ? '✅' : '❌' }}</td>
                    <td>
                        <button class="btn btn-success" wire:click="approve('{{ $review['id'] }}')"
                            wire:confirm="Reconfirm you want to approve this review">
                            <span>Approve</span>
                        </button>
                        <button class="btn btn-danger" wire:click="decline('{{ $review['id'] }}')"
                            wire:confirm="Reconfirm you want to reject this review">
                            <span>Reject</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No orders found.</td>
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
