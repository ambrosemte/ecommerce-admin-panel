<?php

namespace App\Livewire\Chat;

use App\Constants\ApiEndpoints;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ViewChat extends Component
{
    public string $id;
    public string $currentUserId;

    public string $newMessage;
    public array $messages;

    public function mount($id)
    {
        $this->id = $id;
        $this->show();
        $this->dispatch('scrollToBottom');
    }

    protected $listeners = [
        'newMessageReceived' => 'handleNewMessage',
        'agentJoined' => 'handleAgentJoined',
        'agentLeft' => 'handleAgentLeft',
        'conversationClosed' => 'handleConversationClosed',
    ];

    public function handleNewMessage($message)
    {
        $this->messages[] = $message;
        $this->dispatch('scrollToBottom');
    }

    public function handleAgentJoined($agent)
    {
        // Optional: update list of agents
    }

    public function handleAgentLeft($agent)
    {
        // Optional: update list of agents
    }

    public function handleConversationClosed($data)
    {
        // Optional: mark conversation as closed
    }


    public function show()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->get(ApiEndpoints::BASE_URL . ApiEndpoints::VIEW_CHAT . "/{$this->id}");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->messages = $responseData['data'];

        } catch (\Exception $e) {
            Log::error('View Chat Error: ' . $e->getMessage());
            noty()->error("An error occurred while viewing chat. Please try again." . $e->getMessage());
        }
    }

    public function sendMessage()
    {
        if (empty($this->newMessage)) {
            return;
        }
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::SEND_MESSAGE, [
                "conversation_id" => $this->id,
                "message" => $this->newMessage
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            $this->reset('newMessage');
            $this->getMessages();

        } catch (\Exception $e) {
            Log::error('Send Message Error: ' . $e->getMessage());
            noty()->error("An error occurred while sending message. Please try again." . $e->getMessage());
        }

    }

    public function closeConversation()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::CLOSE_CONVERSATION . "/{$this->id}/close");

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            return redirect()->route('chat');

        } catch (\Exception $e) {
            Log::error('Close Conversation Error: ' . $e->getMessage());
            noty()->error("An error occurred while closing conversation. Please try again." . $e->getMessage());
        }
    }

    public function transferConversation()
    {
        try {
            $headers = [
                "Authorization" => "Bearer " . session()->get('token'),
                "Accept" => "application/json"
            ];

            $response = Http::withHeaders($headers)->post(ApiEndpoints::BASE_URL . ApiEndpoints::TRANSFER_CONVERSATION . "/{$this->id}/transfer", [
                "new_agent_id" => ""
            ]);

            $responseData = $response->json();

            if (!$response->successful()) {
                noty()->error($responseData['message']);
                return;
            }

            return redirect()->route('chat');

        } catch (\Exception $e) {
            Log::error('Transfer Conversation Error: ' . $e->getMessage());
            noty()->error("An error occurred while transfering conversation. Please try again." . $e->getMessage());
        }
    }

    #[Layout('components.layouts.app', ['title' => "View Chat"])]
    public function render()
    {
        return view('livewire.chat.view-chat');
    }
}
