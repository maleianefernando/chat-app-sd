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
        <div class="chat-input">
            <button><i class="far fa-smile"></i></button>
            <button><i class="fas fa-paperclip"></i></button>
            <input type="text" placeholder="Escreve uma mensagem..." />
            <button><i class="fas fa-microphone"></i></button>
            <button class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
@endsection
