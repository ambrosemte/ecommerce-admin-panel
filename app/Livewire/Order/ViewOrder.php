<?php

namespace App\Livewire\Order;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViewOrder extends Component
{
    public string $id = '';
    public array $order = [];

    public function mount($id)
    {
        $this->id = $id;
        $this->show();
    }

    public function show()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::VIEW_ORDER . "/" . $this->id);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->order = $responseData['data'];
        } catch (\Exception $e) {
            Log::error('Fetch Order Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching the order. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app', ['title' => "View Order"])]
    public function render()
    {
        return view('livewire.order.view-order');
    }
}
