<?php

namespace App\Livewire\Store;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListStore extends Component
{
    public int $totalStores = 0;
    public int $activeStores = 0;

    public int $page = 1;
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

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_STORES, [
                'page' => $this->page,
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->stores = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];
            $this->totalStores = $responseData['data']['total'];
            $this->activeStores = $responseData['data']['total'];

        } catch (\Exception $e) {
            Log::error('Fetch Store Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching the stores. Please try again." . $e->getMessage());
        }
    }

    public function gotoPage($url)
    {
        $parsedUrl = parse_url($url);
        $query = $parsedUrl['query'] ?? '';

        parse_str($query, $queryParams);

        $this->page = $queryParams['page'] ?? null;

        $this->getStores();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.store.list-store');
    }
}
