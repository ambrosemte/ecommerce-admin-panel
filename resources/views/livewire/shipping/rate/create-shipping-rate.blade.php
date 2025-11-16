<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Create Shipping Rate</h3>
    </div>

    <form wire:submit.prevent="createShippingRate">
        <div class="mb-3 row">
            <div class="col">
                <label for="shipping-method" class="form-label">Shipping Method</label>
                <select id="shipping-method" class="form-select" wire:model.live="shippingMethod">
                    <option value="">-- Select Shipping Method--</option>
                    @foreach ($shippingMethods as $method)
                        <option value="{{ $method['id'] }}">{{ $method['name'] }}</option>
                    @endforeach
                </select>
                @error('shippingMethod')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="shipping-zone" class="form-label">Shipping Zone</label>
                <input type="text" class="form-control" wire:model="shippingZone" disabled>
                @error('shippingZone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col">
                <label for="cost" class="form-label">Cost</label>
                <input type="number" inputmode="decimal" class="form-control" id="cost" wire:model="cost">
                @error('cost')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label for="days-min" class="form-label">Days Min</label>
                <input type="number" inputmode="numeric" class="form-control" id="days-min" wire:model="daysMin">
                @error('daysMin')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="days-max" class="form-label">Days Max</label>
                <input type="number" inputmode="numeric" class="form-control" id="days-max" wire:model="daysMax">
                @error('daysMax')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="createShippingRate">Submit</span>
            <span wire:loading wire:target="createShippingRate">
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>
    </form>
</div>
