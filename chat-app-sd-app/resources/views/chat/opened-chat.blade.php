@extends('layouts.chat')

@section('chat-list')
    @include('chat.partials.chat-list')
@endsection

@section('content')
    <div class="chat-card">
        <input type="text" id="chat-id" value="{{ $chat->id }}" hidden>
        <div class="chat-header">
            <span>
                {{ $chat->is_group ? $chat->name : ($other_side_user->username == null ? $other_side_user->phone : $other_side_user->username) }}
            </span>
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
                    <div class="d-flex justify-content-between message-header">
                        <span class="username"></span>
                        <span class="phone"></span>
                    </div>
                    <span class="message-text">{{ $message->content }}</span>
                    <div class="d-flex justify-content-end message-footer">
                        {{ Carbon\Carbon::parse($message->created_at)->format('H:i') }}
                    </div>
                </div>
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
        const chatId = document.querySelector('#chat-id').value;
        const messageHeader = document.querySelector('.message-header');
        const usernameContainer = document.querySelector('.message-header .username');
        const phoneContainer = document.querySelector('.message-header .phone');
        const messageFooter = document.querySelector('.message-footer');

        const socket = io("http://127.0.0.1:3000");
        console.log('Listening...');

        socket.on("laravel_database_private-chat-app", (data) => {
            const message = data.data;
            // console.log(`Mensagem: ${JSON.stringify(message)}`);

            if (String(chatId) === String(message.chat_id)) {
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
