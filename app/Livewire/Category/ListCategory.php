<?php

namespace App\Livewire\Category;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListCategory extends Component
{
    public int $totalCategories = 0;
    public int $activeCategories = 0;
    public array $categories = [];

    public function mount()
    {
        $this->getCategories();
    }


    public function viewCategory($id)
    {
        return redirect()->route('category.view', ['id' => $id]);
    }

    public function editCategory($id)
    {
        return redirect()->route('category.edit', ['id' => $id]);
    }

    public function getCategories()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_CATEGORIES);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->categories = $responseData['data'];

        } catch (\Exception $e) {
            Log::error('Fetch Category Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching categories. Please try again." . $e->getMessage());
        }
    }

    public function delete($categoryId)
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->delete(ApiEndpoints::BASE_URL . ApiEndpoints::DELETE_CATEGORY ."/{$categoryId}/delete");

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


    #[Layout('components.layouts.app', ['title' => "List Categories"])]
    public function render()
    {
        return view('livewire.category.list-category');
    }
}
