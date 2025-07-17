<div class="chat-container" style="display: flex;">
    <div class="chat-sidebar" style="width: 30%;">
        <livewire:chat-list />
    </div>
    <div class="chat-main" style="width: 70%;">
        @if ($selectedReceiverId)
            <livewire:chat-room :receiverId="$selectedReceiverId" key="{{ $selectedReceiverId }}" />
        @else
            <p class="text-center mt-4 text-gray-400">Pilih pengguna untuk mulai chat</p>
        @endif
    </div>
</div>
