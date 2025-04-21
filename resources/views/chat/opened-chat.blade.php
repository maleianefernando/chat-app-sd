@extends('layouts.chat')

@section('chat-list')
    @include('chat.partials.chat-list')
@endsection

@section('content')
    <div class="chat-card">
        <div class="chat-header">
            <span>
                @if (isset($user))
                    {{ $user }}
                @elseif (isset($group))
                    {{ $group }}
                @else
                    Maria Joao
                @endif
            </span>
            <div>
                <i class="fas fa-video"></i>
                <i class="fas fa-phone mx-3"></i>
                <i class="fas fa-ellipsis-v"></i>
            </div>
        </div>
        <div class="chat-messages">
            @if (isset($user))
            @elseif (isset($group))
            @else
                <div class="message">Olá! Tudo bem?</div>
                <div class="message sent">Tudo ótimo! E contigo?</div>
                <div class="message">
                    <i class="fas fa-play-circle me-2"></i>
                    <span>Áudio - 0:09</span>
                </div>
                <div class="message sent">
                    <i class="fas fa-play-circle me-2"></i>
                    <span>Áudio - 0:06</span>
                </div>
                <div class="message">Olá! Tudo bem?</div>
                <div class="message sent">Tudo ótimo! E contigo?</div>
                <div class="message">
                    <i class="fas fa-play-circle me-2"></i>
                    <span>Áudio - 0:09</span>
                </div>
                <div class="message sent">
                    <i class="fas fa-play-circle me-2"></i>
                    <span>Áudio - 0:06</span>
                </div>
                <div class="message">Olá! Tudo bem?</div>
                <div class="message sent">Tudo ótimo! E contigo?</div>
                <div class="message">
                    <i class="fas fa-play-circle me-2"></i>
                    <span>Áudio - 0:09</span>
                </div>
                <div class="message sent">
                    <i class="fas fa-play-circle me-2"></i>
                    <span>Áudio - 0:06</span>
                </div>
            @endif
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
