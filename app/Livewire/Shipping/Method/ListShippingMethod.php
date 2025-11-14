<?php

namespace App\Livewire\Shipping\Method;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListShippingMethod extends Component
{
    public int $totalMethods = 0;
    public int $activeMethods = 0;
    public array $shippingMethods = [];

    public function mount()
    {
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
            $this->totalMethods = count($this->shippingMethods);
        } catch (\Exception $e) {
            Log::error('Fetch Shipping Methods Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching shipping methods. Please try again." . $e->getMessage());
        }
    }

    public function activateShippingMethod($id)
    {
        $this->updateShippingMethods($id, true);
    }

    public function deactivateShippingMethod($id)
    {
        $this->updateShippingMethods($id, false);
    }

    public function updateShippingMethods(string $id, bool $isActive)
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->patch(ApiEndpoints::BASE_URL . ApiEndpoints::EDIT_SHIPPING_METHOD . "/$id", [
                'is_active' => $isActive
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }
            $this->getShippingMethods();
        } catch (\Exception $e) {
            Log::error('Update Shipping Method Error: ' . $e->getMessage());
            noty()->error("An error occurred while updating shipping method. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shipping.method.list-shipping-method');
    }
}
