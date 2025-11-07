<?php

namespace App\Livewire\Chat;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListChat extends Component
{
    public array $conversations;

    public function mount()
    {
        $this->getConversations();
    }

    public function getConversations()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::LIST_CONVERSATIONS);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->conversations = $responseData['data'];

        } catch (\Exception $e) {
            Log::error('Fetch Conversation Error: ' . $e->getMessage());
            noty()->error("An error occurred while fetching conversations. Please try again." . $e->getMessage());
        }
    }

    public function joinConversation($id)
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::JOIN_CONVERSATION . "/{$id}/join");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            noty()->success($responseData['message']);

            $this->getConversations();

            return redirect()->route('chat.view', ['id' => $id]);

        } catch (\Exception $e) {
            Log::error('Join Conversation Error: ' . $e->getMessage());
            noty()->error("An error occurred while joining conversation. Please try again." . $e->getMessage());
        }
    }

    public function open($id)
    {
        return redirect()->route('chat.view', ['id' => $id]);
    }

    #[Layout('components.layouts.app', ['title' => "All Conversations"])]
    public function render()
    {
        return view('livewire.chat.list-chat');
    }
}
