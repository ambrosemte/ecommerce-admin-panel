<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Create Shipping Zone</h3>
    </div>

    <form wire:submit.prevent="createShippingZone">
        <div class="mb-3 row">
            <div class="col">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" wire:model="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="country" class="form-label">Country</label>
                <select id="country" class="form-select" wire:model.live="countryId">
                    <option value="">-- Select Country--</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                    @endforeach
                </select>
                @error('countryName')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label for="state" class="form-label">State</label>
                <select id="state" class="form-select" wire:model.live="stateId">
                    <option value="">-- Select State--</option>
                    @foreach ($states as $state)
                        <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                    @endforeach
                </select>
                @error('stateName')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col">
                <label for="city" class="form-label">City</label>
                <select id="city" class="form-select" wire:model.live="cityId">
                    <option value="">-- Select City--</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city['id'] }}">{{ $city['name'] }}</option>
                    @endforeach
                </select>
                @error('cityName')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="createShippingZone">Submit</span>
            <span wire:loading wire:target="createShippingZone">
                <span class="spinner-border spinner-border-sm me-1"></span> Processing...
            </span>
        </button>
    </form>
</div>
