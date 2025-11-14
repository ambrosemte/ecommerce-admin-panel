<?php

namespace App\Livewire\Shipping\Method;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CreateShippingMethod extends Component
{
    public string $name = '';

    public function createShippingMethod()
    {
        $this->validate([
            'name' => "required|string"
        ]);

        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::CREATE_SHIPPING_METHOD, [
                'name' => $this->name,
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success($responseData['message']);
            return redirect()->route('shipping.method');

        } catch (\Exception $e) {
            Log::error('Create Shipping Method Error: ' . $e->getMessage());
            noty()->error("An error occurred while creating shipping method. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.shipping.method.create-shipping-method');
    }
}
