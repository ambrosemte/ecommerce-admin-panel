<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">Chat List</h3>
    </div>

    @if(count($conversations) > 0)
        <div class="list-group">
            @foreach($conversations as $conversation)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Customer:</strong> {{ $conversation['customer']['name'] ?? 'N/A' }} <br>
                        <strong>Agent:</strong> {{ $conversation['agents']['name'] ?? 'Unassigned' }} <br>
                        <strong>Status:</strong>
                        @if($conversation['is_completed'])
                            <span class="badge bg-success">Completed</span>
                        @else
                            <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                        <br>
                        <small class="text-muted">Started:
                            {{ \Carbon\Carbon::parse($conversation['created_at'])->format('d M Y H:i') }}</small>
                    </div>

                    <div>
                        @if(!$conversation['is_completed'])
                            @if(!$conversation['agents'])
                                <button wire:click="joinConversation('{{ $conversation['id'] }}')" class="btn btn-sm btn-primary">Join Conversation</button>
                            @else
                                <button wire:click="open('{{ $conversation['id'] }}')" class="btn btn-sm btn-primary">Open</button>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No conversations found.</div>
    @endif
</div>
