<?php

namespace App\Livewire\Specification;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class EditSpecification extends Component
{

    public string $categoryId = '';
    public string $name = '';
    public string $type = '';
    public $values = [''];

    public array $categories = [];

    public function mount()
    {
        $this->categoryId = request()->query('categoryId', '');

        $this->getCategories();
    }

    public function getCategories()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json",
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_CATEGORIES);
            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message'] ?? 'Failed to get categories.');
                return;
            }

            $this->categories = $responseData['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Get Categories Error: ' . $e->getMessage());
            noty()->error('An error occurred while geting categories.');
        }
    }

    public function addValue()
    {
        $this->values[] = '';
    }

    public function removeValue($index)
    {
        unset($this->values[$index]);
        $this->values = array_values($this->values);
    }

    public function editSpecification()
    {
        $this->validate([
            'categoryId' => 'required|string',
            'name' => 'required|string|max:100',
            'type' => 'required|in:text,integer,list,multiple',
            'values' => 'nullable|array',
            'values.*' => 'string|max:255',
        ]);

        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json",
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::EDIT_SPECIFICATION."/", [
                'category_id' => $this->categoryId,
                'name' => $this->name,
                'type' => $this->type,
                'values' => array_filter($this->values), // Remove empty values
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success($responseData['message']);
            $this->reset();
            $this->values = [''];

        } catch (\Exception $e) {
            Log::error('Create Specification Error: ' . $e->getMessage());
            noty()->error('An error occurred while creating the specification.');
        }
    }

    #[Layout('components.layouts.app', ['title' => "Edit Specifications"])]
    public function render()
    {
        return view('livewire.specification.edit-specification');
    }
}
