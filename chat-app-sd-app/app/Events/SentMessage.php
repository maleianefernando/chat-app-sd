<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SentMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    protected $content, $chat_id, $user_id;

    public function __construct(Message $message)
    {
        $this->content = $message->content;
        $this->user_id = $message->user_id;
        $this->chat_id = $message->chat_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat-app'),
        ];
    }

    public function broadcastAs() {
        return 'message.sent';
    }

    public function broadcastWith () {
        $loggedUser = Auth::user();
        return [
            'chat_id' => $this->chat_id,
            'user_id' => $this->user_id,
            'message' => $this->content,
            'logged_user' => $loggedUser->id
        ];
    }
}
