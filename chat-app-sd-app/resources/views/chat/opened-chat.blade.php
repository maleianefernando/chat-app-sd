@extends('layouts.chat')

@section('chat-list')
    @include('chat.partials.chat-list')
@endsection

@section('content')
    <div class="chat-card">
        <div class="chat-header">
            <span>
                {{
                    $chat->is_group ? $chat->name : ( ($other_side_user->username == null) ? $other_side_user->phone : $other_side_user->username )
                }}
            </span>
            <div>
                <i class="fas fa-video"></i>
                <i class="fas fa-phone mx-3"></i>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>
        <div class="chat-messages">
            @foreach ($messages as $message)
                <div class="{{ $message->user_id == $user->id ? 'message sent' : 'message' }}">{{ $message->content }}</div>
            @endforeach
        </div>
        <form method="POST" action="{{ route('message.send') }}">
            @csrf
        <div class="chat-input">
            {{-- <button><i class="far fa-smile"></i></button> --}}
            {{-- <button><i class="fas fa-paperclip"></i></button> --}}
                <input type="number" name="chat-id" value="{{ $chat->id }}" hidden>
                <input type="text" name="message" placeholder="Escreve uma mensagem..." />
                <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                {{-- <button><i class="fas fa-microphone"></i></button> --}}
            </div>
        </form>
    </div>
@endsection

@section('socket-listener')
    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    <script>
        const chatContainer = document.querySelector('.chat-messages');

        const socket = io("http://127.0.0.1:3000");
        console.log('Listening...')
        socket.on("laravel_database_private-chat-app", (data) => {
            const message = data.data;
            console.log(`Mensagem: ${JSON.stringify(message)}`)

            chatContainer.insertAdjacentHTML('beforeend', `
                <div class="${ 'message' }">${message.message}</div>
            `);
        })
    </script>
@endsection
