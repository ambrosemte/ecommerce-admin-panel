<?php

namespace App\Livewire\Category;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateCategory extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $description = '';
    public $image;

    public function createCategory()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'image' => 'required|image|max:5120', // Ensure it's an image (Max 5MB)
        ]);

        try {
            // Convert Livewire file to a real file
            $imagePath = $this->image->getRealPath();
            $imageName = $this->image->getClientOriginalName();

            // API Headers
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)
                ->attach('image', file_get_contents($imagePath), $imageName)
                ->post(ApiEndpoints::BASE_URL . ApiEndpoints::CREATE_CATEGORY, [
                    "name" => $this->name,
                    "description" => $this->description,
                ]);
            $responseData = $response->json();

            if ($response->successful()) {
                $this->reset();
                noty()->success($responseData['message']);
            } else {
                noty()->error($responseData['message']);
            }
        } catch (\Exception $e) {
            Log::error('Create Category Error: ' . $e->getMessage());
            noty()->error("An error occurred while creating category. Please try again.");
        }
    }

    #[Layout('components.layouts.app', ['title' => "Create Category"])]
    public function render()
    {
        return view('livewire.category.create-category');
    }
}
