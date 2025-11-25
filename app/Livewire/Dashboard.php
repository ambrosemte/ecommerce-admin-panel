<?php

namespace App\Livewire;

use App\Constants\ApiEndpoints;
use App\Service\ProfileCacheService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{

    public int $totalSales = 0;
    public int $totalSalesPercentage = 0;
    public string $totalSalesSign = '';
    public int $totalOrders = 0;
    public int $totalOrdersPercentage = 0;
    public string $totalOrdersSign = '';
    public int $totalProducts = 0;
    public int $activeUsers = 0;
    public int $activeUsersPercentage = 0;
    public string $activeUsersSign = '';
    public int $activeSellers = 0;
    public int $activeSellersPercentage = 0;
    public string $activeSellersSign = '';
    public int $activeProducts = 0;
    public array $recentOrders = [];
    public array $recentProducts = [];
    public array $recentUsers = [];
    public array $ordersStatus = [];
    public array $salesTrend = [];

    public function mount()
    {
        $this->getProfile();
        $this->getDashboard();
    }

    public function getProfile()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)
                ->get(ApiEndpoints::BASE_URL . ApiEndpoints::GET_PROFILE);
            $responseData = $response->json();

            if ($response->successful()) {
                app(ProfileCacheService::class)->save($responseData['data']['user']);
            } else {
                noty()->error($responseData['message']);
            }
        } catch (\Exception $e) {
            Log::error('Fetch Profile Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching profile. Please try again.");
        }
    }

    public function getDashboard()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)
                ->get(ApiEndpoints::BASE_URL . ApiEndpoints::GET_DASHBOARD);
            $responseData = $response->json();
            //dd($responseData);

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->totalSales = $responseData['data']['total_sales'];
            $this->totalSalesPercentage = $responseData['data']['total_sales_percentage']['value'];
            $this->totalSalesSign = $responseData['data']['total_sales_percentage']['sign'];
            $this->totalOrders = $responseData['data']['total_orders'];
            $this->totalOrdersPercentage = $responseData['data']['total_orders_percentage']['value'];
            $this->totalOrdersSign = $responseData['data']['total_orders_percentage']['sign'];
            $this->activeUsers = $responseData['data']['active_users'];
            $this->activeUsersPercentage = $responseData['data']['active_users_percentage']['value'];
            $this->activeUsersSign = $responseData['data']['active_users_percentage']['sign'];
            $this->activeSellers = $responseData['data']['active_sellers'];
            $this->activeSellersPercentage = $responseData['data']['active_sellers_percentage']['value'];
            $this->activeSellersSign = $responseData['data']['active_sellers_percentage']['sign'];
            $this->activeProducts = $responseData['data']['active_products'];
            $this->activeProducts = $responseData['data']['active_products'];
            $this->recentOrders = $responseData['data']['recent_orders'];
            $this->recentUsers = $responseData['data']['recent_users'];
            $this->ordersStatus = $responseData['data']['orders_status'];
            $this->salesTrend = $responseData['data']['sales_trend'];

        } catch (\Exception $e) {
            Log::error('Fetch Dashboard Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching dashboard. Please try again.");
        }
    }


    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.dashboard');
    }
}
