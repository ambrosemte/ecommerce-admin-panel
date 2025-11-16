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
    protected $actionEndpoints = [
        'accept' => ApiEndpoints::ACCEPT_ORDER,
        'decline' => ApiEndpoints::DECLINE_ORDER,
        'process' => ApiEndpoints::PROCESS_ORDER,
        'ship' => ApiEndpoints::SHIP_ORDER,
        'out_for_delivery' => ApiEndpoints::OUT_FOR_DELIVERY_ORDER,
        'delivered' => ApiEndpoints::DELIVERED_ORDER,
        'approve_refund' => ApiEndpoints::APPROVE_REFUND_ORDER,
        'decline_refund' => ApiEndpoints::DECLINE_REFUND_ORDER,
    ];

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

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::VIEW_ORDER . "/$this->id");

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

    public function handleOrderAction(string $action)
    {
        try {
            // Check if the action exists in our mapping
            if (!isset($this->actionEndpoints[$action])) {
                noty()->error("Invalid action: {$action}");
                return;
            }

            $endpoint = $this->actionEndpoints[$action];

            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)
                ->put(ApiEndpoints::BASE_URL . $endpoint . "/$this->id");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->show();

            noty()->success($responseData['message']);

        } catch (\Exception $e) {
            Log::error('Order Action Error: ' . $e->getMessage());
            noty()->error("An error occurred while performing the action: " . $e->getMessage());
        }
    }


    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.order.view-order');
    }
}
