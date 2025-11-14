<?php

namespace App\Livewire\Shipping\Rate;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateShippingRate extends Component
{
    public string $shippingMethod;
    public string $shippingZoneId;
    public string $shippingZone;
    public float $cost;
    public int $daysMax;
    public int $daysMin;
    public array $shippingMethods = [];

    public function mount()
    {
        $this->shippingZoneId = request()->get('shipping-zone-id') ?? '';
        $this->shippingZone = request()->get('shipping-zone') ?? '';

        $this->getShippingMethods();
    }

    public function getShippingMethods()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_SHIPPING_METHODS);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->shippingMethods = $responseData['data'];
        } catch (\Exception $e) {
            Log::error('Fetch Shipping Methods Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching shipping methods. Please try again." . $e->getMessage());
        }
    }

    public function createShippingRate()
    {
        $this->validate([
            'shippingMethod' => "required|string",
            'shippingZone' => "required|string",
            'cost' => 'required|numeric|decimal:0,2',
            'daysMax' => "required|numeric",
            'daysMin' => "required|numeric",
        ]);

        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::CREATE_SHIPPING_RATE, [
                'shipping_method_id' => $this->shippingMethod,
                'shipping_zone_id' => $this->shippingZoneId,
                'cost' => $this->cost,
                'days_max' => $this->daysMax,
                'days_min' => $this->daysMin,
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success($responseData['message']);
            return redirect()->route('shipping.rate');
        } catch (\Exception $e) {
            Log::error('Create Shipping Rate Error: ' . $e->getMessage());
            noty()->error("An error occurred while creating shipping rates. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shipping.rate.create-shipping-rate');
    }
}
