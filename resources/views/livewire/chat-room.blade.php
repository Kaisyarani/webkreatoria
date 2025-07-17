<div wire:poll.2s>
    <div style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;">
        @foreach ($messages as $msg)
            <div class="{{ $msg->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
                <strong>{{ $msg->sender_id == auth()->id() ? 'Saya' : 'Pengguna ' . $msg->sender_id }}</strong><br>
                {{ $msg->message }}
            </div>
        @endforeach
    </div>

    <input type="text" wire:model="messageText" wire:keydown.enter="sendMessage" placeholder="Ketik pesan..." class="form-control mt-2">
</div>
