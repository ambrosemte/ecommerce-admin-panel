<div class="container mt-4">
    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Categories</h5>
                    <h3 class="fw-bold">{{ $totalCategories }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-success text-center">
                <div class="card-body">
                    <h5 class="card-title">Active Categories</h5>
                    <h3 class="fw-bold">{{ $activeCategories }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-bg-secondary text-center">
                <div class="card-body">
                    <h5 class="card-title">Inactive Categories</h5>
                    <h3 class="fw-bold">{{ $totalCategories - $activeCategories }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Categories Table --}}
    <h4 class="mb-3">Categories List</h4>

    <table class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Enabled</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $index => $category)
                <tr>
                    <td>{{  $index + 1 }}</td>
                    <td class="d-flex align-items-center">
                        {{-- Circular image --}}
                        <img src="{{ $category['image_url'] ?? asset('images/default.png') }}" alt="{{ $category['name'] }}"
                            class="rounded-circle me-2" width="40" height="40">
                        {{ $category['name'] }}
                    </td>
                    <td>{{ $category['description'] }}</td>
                    <td>{{ $category['is_active'] ? '✅' : '❌' }}</td>
                    <td>
                        <button class="btn btn-primary" wire:click="viewCategory('{{ $category['id'] }}')">
                            <span>View</span>
                        </button>
                        <button class="btn btn-secondary" wire:click="editCategory('{{ $category['id'] }}')">
                            <span>Edit</span>
                        </button>
                        <button class="btn btn-danger" wire:click="delete('{{ $category['id'] }}')"
                            wire:confirm="Are you sure you want to delete this category?">
                            <span>Delete</span>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
