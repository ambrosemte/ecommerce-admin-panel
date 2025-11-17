<?php

namespace App\Livewire\User;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListUser extends Component
{
    public int $totalUsers = 0;
    public int $activeUsers = 0;
    public array $users = [];
    public array $links = [];

    public function mount()
    {
        $this->getUsers();
    }

    public function getUsers()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_USERS);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->users = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];
            $this->totalUsers = $responseData['data']['total'];
            $this->activeUsers=$responseData['data']['total'];
        } catch (\Exception $e) {
            Log::error('Fetch Store Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching the stores. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.user.list-user');
    }
}
