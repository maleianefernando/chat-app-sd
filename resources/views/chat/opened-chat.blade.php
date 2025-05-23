@extends('layouts.chat')

@section('chat-list')
    @include('chat.partials.chat-list')
@endsection

@section('content')
    <div class="chat-card">
        <input type="text" id="chat-id" value="{{ $chat->id }}" hidden>
        <input type="text" id="user-id" value="{{ $user->id }}" hidden>
        <div class="d-flex justify-content-between align-items-center chat-header">
            <div class="user-item opened-chat-header">
                <img
                    src="https://png.pngtree.com/png-vector/20190420/ourmid/pngtree-vector-business-man-icon-png-image_966609.jpg"
                    class="rounded-circle me-2" alt="User"
                />
                <span class="opened-chat title">
                    {{ $chat->is_group ? $chat->name : ($other_side_user->username == null ? $other_side_user->phone : $other_side_user->username) }}
                </span>
                <span class="opened-chat user-status">
                    @if(isset($other_side_user->id))
                    <input type="number" value="{{ $other_side_user->id }}" class="user-id" hidden />
                    <span class="status-text">offline</span>
                    @endif
                </span>
            </div>
            <div>
                <i class="fas fa-video"></i>
                <i class="fas fa-phone mx-3"></i>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>

        @php
            $previous = null;
        @endphp
        <div class="chat-messages">
            @foreach ($messages as $message)
                @if ($loop->index == 0)
                    <div class="d-flex justify-content-center rounded-3 date-separator">
                        {{ Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}
                    </div>
                @elseif(Carbon\Carbon::parse($message->created_at)->format('d-m-Y') ==
                        Carbon\Carbon::parse($previous->created_at)->format('d-m-Y'))

                @elseif(Carbon\Carbon::parse($message->created_at)->format('d-m-Y') == Carbon\Carbon::now()->format('d-m-Y'))
                    <div class="d-flex justify-content-center rounded-3 date-separator">
                        Hoje
                    </div>
                @else
                    <div class="d-flex justify-content-center rounded-3 date-separator">
                        {{ Carbon\Carbon::parse($message->created_at)->format('d/m/Y') }}
                    </div>
                @endif
                @php
                    $previous = $message;
                @endphp

                <div class="{{ $message->user_id == $user->id ? 'message sent' : 'message' }} pb-1">
                    @if($chat->is_group && $user->id != $message->user_id)
                    <div class="d-flex justify-content-between message-header">
                        <span class="username">{{ $message_usernames[$loop->index]['username'] }}</span>
                        <span class="phone">{{ $message_usernames[$loop->index]['phone'] }}</span>
                    </div>
                    @endif
                    <span class="message-text">{{ $message->content }}</span>
                    <div class="d-flex justify-content-end message-footer">
                        {{ Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                    </div>
                </div>
            @endforeach
        </div>
        <form method="POST" action="/msg/send">
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
    {{-- <script src="{{ asset('js/onlineUsers.js') }}"></script> --}}
    <script>
        const chatContainer = document.querySelector('.chat-messages');
        const chatId = document.querySelector('#chat-id').value;
        const messageHeader = document.querySelector('.message-header');
        const usernameContainer = document.querySelector('.message-header .username');
        const phoneContainer = document.querySelector('.message-header .phone');
        const messageFooter = document.querySelector('.message-footer');
        // const webSocketServer = `https://chat-app-sd-websockets.onrender.com`;

        const socket = io("https://chat-app-sd-websockets.onrender.com");
        console.log('Listening...');

        socket.on("laravel_database_private-chat-app", (data) => {
            const message = data.data;
            console.log(message);

            if (String(chatId) === String(message.chat_id)) {
                console.log('inside');
                chatContainer.insertAdjacentHTML('beforeend', `
                    <div class="message">
                        <div class="d-flex justify-content-between message-header chat-${message.chat_id}">
                            <span class="username">
                                ${message.username}
                            </span>
                            <span class="phone">
                                ${message.phone}
                            </span>
                        </div>
                        <span class="message-text">
                            ${message.message}
                        </span>
                        <div class="d-flex justify-content-end message-footer">
                            ${message.created_at}
                        </div>
                    </div>
                `);
                if(!message.is_group) {
                    // console.log(document.querySelector(`.message-header.chat-${message.chat_id}`))
                    document.querySelector(`.message-header.chat-${message.chat_id}`).remove();
                }
            }
            console.log('after')
            scrollToLastMsg();
        });

        window.onload = () => {
            scrollToLastMsg();
        }

        function scrollToLastMsg() {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
    </script>
@endsection
