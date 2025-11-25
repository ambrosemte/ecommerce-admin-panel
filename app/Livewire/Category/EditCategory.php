<?php

namespace App\Livewire\Category;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditCategory extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $description = '';
    public string $imageUrl = '';
    public string $id = '';
    public string $existingImage = '';
    public int $status;
    public $image;
    public array $category = [];

    public function mount($id)
    {
        $this->id = $id;
        $this->show();
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

            $this->name = $responseData['data']['name'];
            $this->description = $responseData['data']['description'] ?? '';
            $this->imageUrl = $responseData['data']['image_url'] ?? '';
            $this->status = $responseData['data']['is_active'];
            $this->existingImage = $responseData['data']['image_url'] ?? '';
        } catch (\Exception $e) {
            Log::error('Fetch Category Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching the category. Please try again." . $e->getMessage());
        }
    }

    public function editCategory()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120', // Ensure it's an image (Max 5MB)
            'status' => 'boolean|required'
        ]);

        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $payload = [
                'name' => $this->name,
                'description' => $this->description,
                'is_active' => $this->status,
            ];

            $request = Http::withHeaders($headers);

            if (!empty($this->image)) {
                $request->attach('image', file_get_contents($this->image->getRealPath()), $this->image->getClientOriginalName());
            }

            $response = $request->post(ApiEndpoints::BASE_URL . ApiEndpoints::EDIT_CATEGORY . "/{$this->id}/update", $payload);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success($responseData['message']);
            return redirect()->route('category');
        } catch (\Exception $e) {
            Log::error('Edit Category Error: ' . $e->getMessage());
            noty()->error("An error occurred while editing category. Please try again.");
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.category.edit-category');
    }
}
