<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
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
    protected $content, $chat_id, $is_group, $user_id, $username, $phone, $created_at;

    public function __construct(Message $message)
    {
        $chat = Chat::find($message->chat_id);
        $user = User::find($message->user_id);

        $this->content = $message->content;
        $this->chat_id = $message->chat_id;
        $this->is_group = $chat->is_group ? true : false;
        $this->user_id = $user->id;
        $this->username = $user->username;
        $this->phone = $user->phone;
        $this->created_at = Carbon::parse($message->created_at)->format('H:i');
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
            'message' => $this->content,
            'chat_id' => $this->chat_id,
            'is_group' => $this->is_group,
            'user_id' => $this->user_id,
            'username' => $this->username,
            'phone' => $this->phone,
            'logged_user' => $loggedUser->id,
            'created_at' => $this->created_at,
        ];
    }
}
