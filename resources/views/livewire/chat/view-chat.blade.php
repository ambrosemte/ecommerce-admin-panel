<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span>Chat</span>
            <div>
                <button class="btn btn-sm btn-warning me-2" wire:click="transferConversation">Transfer</button>
                <button class="btn btn-sm btn-secondary" wire:click="closeConversation">Close</button>
            </div>
        </div>
        <div class="card-body" style="height:400px; overflow-y:auto;">
            @foreach($messages as $msg)
                @php
                    $isCurrentUser = $msg['sender_role'] === 'admin' || $msg['sender_role'] === 'agent';
                @endphp
                <div class="d-flex mb-3 {{ $isCurrentUser ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-2 rounded {{ $isCurrentUser ? 'bg-primary text-white' : 'bg-light' }}"
                        style="max-width:70%;">
                        <small class="text-muted">{{ $msg['sender']['name'] }}</small><br>
                        {{ $msg['message'] }}
                        <div class="text-end">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-footer">
            <form wire:submit.prevent="sendMessage">
                <div class="input-group">
                    <input type="text" wire:model.defer="newMessage" class="form-control"
                        placeholder="Type a message...">
                    <button class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.ably.io/lib/ably.min-1.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            const ably = new Ably.Realtime({ key: "{{ env('ABLY_KEY') }}" });
            const channel = ably.channels.get('conversation.{{ $id }}');

            // Subscribe to new messages
            channel.subscribe('new-message', function (msg) {
                alert(msg);
                Livewire.emit('newMessageReceived', msg.data);
            });

            // Optional: subscribe to agent events
            channel.subscribe('agent-joined', function (msg) {
                Livewire.emit('agentJoined', msg.data);
            });
            channel.subscribe('agent-left', function (msg) {
                Livewire.emit('agentLeft', msg.data);
            });

            // Optional: conversation closed
            channel.subscribe('conversation-closed', function (msg) {
                Livewire.emit('conversationClosed', msg.data);
            });
        });

        window.addEventListener('scrollToBottom', function () {
            const container = document.querySelector('.card-body');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</div>
