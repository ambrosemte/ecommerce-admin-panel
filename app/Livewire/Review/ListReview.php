<?php

namespace App\Livewire\Review;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListReview extends Component
{
    public int $totalReviews = 0;
    public int $approvedReviews = 0;
    public int $page = 1;
    public array $reviews = [];
    public array $links = [];

    public function mount()
    {
        $this->getReviews();
    }


    public function viewOrder($id)
    {
        return redirect()->route('order.view', ['id' => $id]);
    }

    public function getReviews()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_REVIEWS, [
                'page' => $this->page,
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->reviews = $responseData['data']['data'];
            $this->links = $responseData['data']['links'];
            $this->totalReviews = $responseData['data']['total'];
            $this->approvedReviews = $responseData['data']['total_approved'];
        } catch (\Exception $e) {
            Log::error('Fetch Reviews Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching reviews. Please try again." . $e->getMessage());
        }
    }

    public function approve(string $id)
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->patch(ApiEndpoints::BASE_URL . ApiEndpoints::APPROVE_REVIEW . "/$id");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->getReviews();
            noty()->success($responseData['message']);
        } catch (\Exception $e) {
            Log::error('Approve Review Error: ' . $e->getMessage());
            noty()->error("An error occurred while approving review. Please try again." . $e->getMessage());
        }
    }

    public function decline(string $id)
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->patch(ApiEndpoints::BASE_URL . ApiEndpoints::DECLINE_REVIEW . "/$id");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->getReviews();
            noty()->success($responseData['message']);
        } catch (\Exception $e) {
            Log::error('Decline Review Error: ' . $e->getMessage());
            noty()->error("An error occurred while declining review. Please try again." . $e->getMessage());
        }
    }

    public function gotoPage($url)
    {
        $parsedUrl = parse_url($url);
        $query = $parsedUrl['query'] ?? '';

        parse_str($query, $queryParams);

        $this->page = $queryParams['page'] ?? null;

        $this->getReviews();
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.review.list-review');
    }
}
