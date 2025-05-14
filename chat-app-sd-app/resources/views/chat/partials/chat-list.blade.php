@foreach ($chats as $chat)
    <div class="chat-item user-item">
        <a href="{{ route('chat.specific', $chat->id) }}" class="chat-item-link">
            <div class="profile-wrapper position-relative">
                <img
                    src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
                    class="rounded-circle me-2" alt="User" />
                    <span
                    class="status-indicator user-{{ $user_id_to_check_online[$loop->index] }}"></span>
                    <span>{{ $chat_names['' . $chat->id] }}</span>
            </div>
            </a>
    </div>
@endforeach

{{-- $chat->is_group ? $chat->name : ( ($other_side_user->username == null) ? $other_side_user->phone : $other_side_user->username ) --}}
