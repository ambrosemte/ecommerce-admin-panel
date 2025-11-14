<?php

namespace App\Livewire\Category;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViewCategory extends Component
{
    public string $id = '';
    public array $category = [];

    public function mount($id)
    {
        $this->id = $id;
        $this->show();
    }

    public function addSpecification()
    {
        return redirect()->route('specification.create', ['categoryId' => $this->id]);
    }

    public function editSpecification($specificationId)
    {
        return redirect()->route('specification.edit', ['id' => $specificationId]);
    }


    public function show()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::VIEW_CATEGORY . "/" . $this->id);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->category = $responseData['data'];
        } catch (\Exception $e) {
            Log::error('Fetch Category Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching the category. Please try again." . $e->getMessage());
        }
    }

    public function deleteSpecification($specificationKeyId)
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->delete(
                ApiEndpoints::BASE_URL . ApiEndpoints::DELETE_SPECIFICATION . "/{$specificationKeyId}"
            );

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success('Specification deleted successfully.');
            $this->show();

        } catch (\Exception $e) {
            Log::error('Delete Specification Error: ' . $e->getMessage());
            noty()->error("An error occurred while deleting the specification.");
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.category.view-category');
    }
}
