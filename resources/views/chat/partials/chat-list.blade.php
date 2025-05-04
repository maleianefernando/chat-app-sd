
@foreach ($chats as $chat)
<div class="chat-item user-item"><a href="{{ route('chat.specific', $chat->id) }}" class="chat-item-link"><img
    src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
    class="rounded-circle me-2" alt="User" /><span>{{ $chat_names["".$chat->id] }}</span></a>
</div>
@endforeach

{{-- $chat->is_group ? $chat->name : ( ($other_side_user->username == null) ? $other_side_user->phone : $other_side_user->username ) --}}
