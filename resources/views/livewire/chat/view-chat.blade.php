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
                @if ($msg['is_user_message'])
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
                @else
                    {{-- System message (agent joined the chat) --}}
                    <div class="text-center my-3">
                        <div class="d-inline-block px-3 py-2 bg-light rounded-pill">
                            <div class="text-muted small fw-semibold">
                                {{ $msg['message'] }}
                            </div>
                            <div class="text-muted" style="font-size: 11px;">
                                {{ \Carbon\Carbon::parse($msg['created_at'])->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endif

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
        // Check which Livewire version you're using
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Script loaded');

            const ably = new Ably.Realtime({
                key: "{{ env('ABLY_KEY') }}",
                log: { level: 4 } // Enable debugging
            });

            const channel = ably.channels.get('conversation.{{ $id }}');

            console.log('Ably initialized, channel:', 'conversation.{{ $id }}');

            // Check connection status
            ably.connection.on('connected', function () {
                console.log('Ably connected successfully');
            });

            ably.connection.on('failed', function (stateChange) {
                console.error('Ably connection failed:', stateChange);
            });

            // Subscribe to new messages
            channel.subscribe('new-message', function (msg) {
                console.log('New message received:', msg.data);
                window.Livewire.dispatch('newMessageReceived', { message: msg.data });
            });

            // Agent events
            channel.subscribe('agent-joined', function (msg) {
                console.log('Agent joined:', msg.data);
                window.Livewire.dispatch('agentJoined', msg);
            });

            channel.subscribe('agent-left', function (msg) {
                console.log('Agent left:', msg.data);
                window.Livewire.dispatch('agentLeft', msg);
            });

            channel.subscribe('conversation-closed', function (msg) {
                console.log('Conversation closed:', msg.data);
                window.Livewire.dispatch('conversationClosed', msg);
            });
        });

        window.addEventListener('scrollToBottom', function () {
            const container = document.querySelector('.card-body');
            if (!container) return;

            // Wait until DOM updates
            requestAnimationFrame(() => {
                container.scrollTop = container.scrollHeight;
            });
        });
    </script>
</div>
