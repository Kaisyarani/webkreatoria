<div>
    @foreach($users as $user)
        <div class="contact-item" wire:click="startChat({{ $user->id }})">
            <img src="{{ $user->kreatorProfile?->photo ? asset('storage/' . $user->kreatorProfile->photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" alt="{{ $user->name }}">
            <div class="contact-details">
                <div class="name">{{ $user->name }}</div>
                <p class="last-message">{{ $user->lastMessage?->content ?? 'Belum ada pesan' }}</p>
            </div>
            <div class="contact-meta">
                @if($user->unread_count > 0)
                    <span class="unread-badge">{{ $user->unread_count }}</span>
                @endif
            </div>
        </div>
    @endforeach
</div>
