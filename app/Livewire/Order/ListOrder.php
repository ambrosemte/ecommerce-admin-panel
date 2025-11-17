<?php

namespace App\Livewire\Order;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListOrder extends Component
{

    public int $totalOrders = 0;
    public int $activeOrders = 0;
    public array $orders = [];
    public array $links = [];

    public function mount()
    {
        $this->getOrders();
    }


    public function viewOrder($id)
    {
        return redirect()->route('order.view', ['id' => $id]);
    }

    public function getOrders()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_ORDERS);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->orders = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];
            $this->totalOrders=$responseData['data']['total'];
        } catch (\Exception $e) {
            Log::error('Fetch Order Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching orders. Please try again." . $e->getMessage());
        }
    }

    public function delete($categoryId)
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->delete(ApiEndpoints::BASE_URL . ApiEndpoints::DELETE_CATEGORY . "/{$categoryId}/delete");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success($responseData['message']);
            $this->getCategories();

        } catch (\Exception $e) {
            Log::error('Delete Category Error: ' . $e->getMessage());
            noty()->error("An error occurred while deleting the category. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.order.list-order');
    }
}
