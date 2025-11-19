<?php

namespace App\Livewire\Product;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListProduct extends Component
{
    public int $totalProducts = 0;
    public int $page = 1;
    public array $products = [];
    public array $links = [];

    public function mount()
    {
        $this->getProducts();
    }

    public function getProducts()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)
                ->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_PRODUCTS, [
                    'page' => $this->page,
                ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->products = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];
            $this->totalProducts = $responseData['data']['total'];

        } catch (\Exception $e) {
            Log::error('Fetch Products Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching products. Please try again." . $e->getMessage());
        }

    }

    public function gotoPage($url)
    {
        $parsedUrl = parse_url($url);
        $query = $parsedUrl['query'] ?? '';

        parse_str($query, $queryParams);

        $this->page = $queryParams['page'] ?? null;

        $this->getProducts();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.product.list-product');
    }
}
