<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Create Specification</h3>
    </div>

    <form wire:submit.prevent="createSpecification">
        <div class="mb-3 row">
            <div class="col">
                <label for="categoryId" class="form-label">Category</label>
                <select id="categoryId" class="form-select" wire:model="categoryId">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
                @error('categoryId')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label for="name" class="form-label">Specification Name</label>
                <input type="text" class="form-control" id="name" wire:model="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label for="type" class="form-label">Type</label>
                <select id="type" class="form-select" wire:model.live="type">
                    <option value="">-- Select Type --</option>
                    <option value="text">Text</option>
                    <option value="integer">Integer</option>
                    <option value="list">List</option>
                    <option value="multiple">Multiple</option>
                </select>
                @error('type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @if(in_array($type, ['list', 'multiple']))
            <div class="mb-3 row">
                <div class="col">
                    <label class="form-label">Values</label>
                    @foreach ($values as $index => $value)
                        <div class="d-flex mb-2 align-items-center">
                            <input type="text" class="form-control me-2" wire:model="values.{{ $index }}">
                            <button type="button" class="btn btn-danger btn-sm"
                                wire:click="removeValue({{ $index }})">×</button>
                        </div>
                    @endforeach

                    <button type="button" class="btn btn-secondary btn-sm" wire:click="addValue">
                        <span wire:loading.remove wire:target="addValue">+ Add Value</span>
                        <span wire:loading wire:target="addValue">
                            <span class="spinner-border spinner-border-sm me-1"></span> Processing...
                        </span>
                    </button>

                    @error('values.*')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        @endif
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="createSpecification">
            <span wire:loading.remove wire:target="createSpecification">Submit</span>
            <span wire:loading wire:target="createSpecification">
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>
    </form>
</div>
