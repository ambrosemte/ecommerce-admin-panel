<div class="container">
     <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Create Category</h3>
    </div>

    <form wire:submit.prevent="createCategory">
        <div class="mb-3 row">
            <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" wire:model="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" wire:model="description"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" wire:model="image" accept="image/*">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="w-24 h-24 rounded-lg shadow-md object-cover" width="150">
            @else
                <img src="{{ asset('images/default.png') }}" class="w-24 h-24 rounded-lg shadow-md object-cover" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Submit</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>
    </form>
</div>
