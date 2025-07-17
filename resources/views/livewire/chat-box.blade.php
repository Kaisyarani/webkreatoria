<div wire:poll.3s>
    @if($receiver)
        <div style="max-height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            @foreach($messages as $message)
                <div class="{{ $message->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
                    <strong>{{ $message->sender_id == auth()->id() ? 'Saya' : $receiver->name }}</strong><br>
                    {{ $message->message }}
                </div>
            @endforeach
        </div>

        <form wire:submit.prevent="sendMessage">
            <div class="d-flex gap-2">
                <input type="text" wire:model="content" placeholder="Tulis pesan..." class="form-control" required>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </form>
    @else
        <p class="text-muted">Pilih pengguna untuk memulai obrolan.</p>
    @endif
</div>
