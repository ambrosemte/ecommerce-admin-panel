<?php

namespace App\Livewire\Shipping\Zone;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListShippingZone extends Component
{
    public int $totalZones = 0;
    public int $activeZones = 0;
    public int $page = 1;
    public array $shippingZones = [];
    public array $links = [];


    public function mount()
    {
        $this->getShippingZones();
    }

    public function getShippingZones()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_SHIPPING_ZONES, [
                'page' => $this->page,
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->shippingZones = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];
            $this->totalZones = count($this->shippingZones);
        } catch (\Exception $e) {
            Log::error('Fetch Shipping Zones Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching shipping zones. Please try again." . $e->getMessage());
        }
    }

    public function viewShippingRate(string $shippingZoneId)
    {
        return redirect()->route('shipping.rate.view', $shippingZoneId);
    }

    public function createShippingRate(string $id, string $name)
    {
        return redirect()->route('shipping.rate.create', ['shipping-zone-id' => $id, 'shipping-zone' => $name]);
    }

    public function gotoPage($url)
    {
        $parsedUrl = parse_url($url);
        $query = $parsedUrl['query'] ?? '';

        parse_str($query, $queryParams);

        $this->page = $queryParams['page'] ?? null;

        $this->getShippingZones();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shipping.zone.list-shipping-zone');
    }
}
