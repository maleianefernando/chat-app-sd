@foreach ($chats as chat)
<div class="chat-item user-item"><a href="{{ route('chat.specific', 1) }}" class="chat-item-link"><img
    src="https://img.freepik.com/free-photo/no-idea_273609-23908.jpg?t=st=1744608982~exp=1744612582~hmac=9f2c831411c907be117bb07d9330499b08afe231d4fc7c1354ea7c0a3c1c98db&w=996"
    class="rounded-circle me-2" alt="User" /><span>{{ $user }}</span></a>
</div>
@endforeach

@if (isset($user))
<div class="chat-item user-item"><a href="{{ route('chat.specific', 1) }}" class="chat-item-link"><img
    src="https://img.freepik.com/free-photo/no-idea_273609-23908.jpg?t=st=1744608982~exp=1744612582~hmac=9f2c831411c907be117bb07d9330499b08afe231d4fc7c1354ea7c0a3c1c98db&w=996"
    class="rounded-circle me-2" alt="User" /><span>{{ $user }}</span></a>
</div>
@elseif (isset($group))
<div class="chat-item user-item"><a href="{{ route('chat.specific', 1) }}" class="chat-item-link"><img
    src="https://img.freepik.com/free-photo/no-idea_273609-23908.jpg?t=st=1744608982~exp=1744612582~hmac=9f2c831411c907be117bb07d9330499b08afe231d4fc7c1354ea7c0a3c1c98db&w=996"
    class="rounded-circle me-2" alt="User" /><span>{{ $group }}</span></a>
</div>
@endif
<div class="chat-item user-item"><a href="{{ route('chat.specific', 1) }}" class="chat-item-link"><img
    src="https://img.freepik.com/free-photo/no-idea_273609-23908.jpg?t=st=1744608982~exp=1744612582~hmac=9f2c831411c907be117bb07d9330499b08afe231d4fc7c1354ea7c0a3c1c98db&w=996"
    class="rounded-circle me-2" alt="User" /><span>+258 84 000 0000</span></a>
</div>
<div class="chat-item user-item"><a href="{{ route('chat.specific', 1) }}" class="chat-item-link"><img
    src="https://img.freepik.com/free-photo/no-idea_273609-23908.jpg?t=st=1744608982~exp=1744612582~hmac=9f2c831411c907be117bb07d9330499b08afe231d4fc7c1354ea7c0a3c1c98db&w=996"
    class="rounded-circle me-2" alt="User" /><span>Maria João</span></a>
</div>
<div class="chat-item user-item"><a href="{{ route('chat.specific', 1) }}" class="chat-item-link"><img
    src="https://img.freepik.com/free-photo/no-idea_273609-23908.jpg?t=st=1744608982~exp=1744612582~hmac=9f2c831411c907be117bb07d9330499b08afe231d4fc7c1354ea7c0a3c1c98db&w=996"
    class="rounded-circle me-2" alt="User" /><span>Carlos Silva</span></a>
</div>

