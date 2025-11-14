<?php

namespace App\Livewire\Shipping\Zone;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateShippingZone extends Component
{
    public string $name = '';

    // Countries
    public array $countries = [];
    public string $countryId = '';
    public string $countryName = '';

    // States
    public array $states = [];
    public string $stateId = '';
    public string $stateName = '';

    // Cities
    public array $cities = [];
    public string $cityId = '';
    public string $cityName = '';

    public function mount()
    {
        $this->getCountries();
    }

    /**
     * Load countries from JSON
     */
    public function getCountries()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_COUNTIRES);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->countries = $responseData['data'];

        } catch (\Exception $e) {
            Log::error('Fetch Countries Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching countries. Please try again." . $e->getMessage());
        }
    }

    public function updatedCountryId($id)
    {
        $country = collect($this->countries)->firstWhere('id', $id);

        if ($country) {
            $this->countryId = $country['id'];
            $this->countryName = $country['name'];
        } else {
            $this->countryId = '';
            $this->countryName = '';
        }

        $this->stateId = '';
        $this->stateName = '';
        $this->cityId = '';
        $this->cityName = '';

        $this->getstates();
    }

    public function getstates()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_STATES . "/$this->countryId/states");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->states = $responseData['data'];

        } catch (\Exception $e) {
            Log::error('Fetch States Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching states. Please try again." . $e->getMessage());
        }
    }

    public function updatedStateId($id)
    {
        $state = collect($this->states)->firstWhere('id', $id);

        if ($state) {
            $this->stateId = $state['id'];
            $this->stateName = $state['name'];
        } else {
            $this->stateId = '';
            $this->stateName = '';
        }

        $this->cityId = '';
        $this->cityName = '';

        $this->getCities();
    }

    public function getCities()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_CITIES . "/$this->stateId/cities");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->cities = $responseData['data'];

        } catch (\Exception $e) {
            Log::error('Fetch Cities Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching cities. Please try again." . $e->getMessage());
        }
    }

    public function updatedCityId($id)
    {
        $cities = collect($this->cities)->firstWhere('id', $id);

        if ($cities) {
            $this->cityId = $cities['id'];
            $this->cityName = $cities['name'];
        } else {
            $this->cityId = '';
            $this->cityName = '';
        }
    }

    public function createShippingZone()
    {
        $this->validate([
            'name' => "required|string",
            'countryName' => "required|string",
            'stateName' => "required|string",
            'cityName' => "required|string",
        ]);

        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::CREATE_SHIPPING_ZONE, [
                'name' => $this->name,
                'country' => $this->countryName,
                'state' => $this->stateName,
                'city' => $this->cityName,
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success($responseData['message']);
            return redirect()->route('shipping.zone');

        } catch (\Exception $e) {
            Log::error('Create Shipping Zone Error: ' . $e->getMessage());
            noty()->error("An error occurred while creating shipping zone. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shipping.zone.create-shipping-zone');
    }
}
