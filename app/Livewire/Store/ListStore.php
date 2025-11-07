<?php

namespace App\Livewire\Store;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListStore extends Component
{
    public int $totalStores=0;
    public int $activeStores=0;
    public array $stores = [];
    public array $links = [];

    public function mount()
    {
        $this->getStores();
    }

    public function getStores()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_STORES);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->stores = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];

        } catch (\Exception $e) {
            Log::error('Fetch Store Error: ' . $e->getMessage());
           noty()->error("An error occurred while fetching the stores. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app', ['title' => "List Stores"])]
    public function render()
    {
        return view('livewire.store.list-store');
    }
}
