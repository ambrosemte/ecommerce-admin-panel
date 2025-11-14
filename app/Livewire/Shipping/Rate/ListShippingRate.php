<?php

namespace App\Livewire\Shipping\Rate;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListShippingRate extends Component
{
    public array $shippingRates = [];
    public array $links = [];

    public function mount()
    {
        $this->getShippingRates();
    }

    public function getShippingRates()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_SHIPPING_RATES);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->shippingRates = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];
        } catch (\Exception $e) {
            Log::error('Fetch Shipping Rates Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching shipping rates. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shipping.rate.list-shipping-rate');
    }
}
