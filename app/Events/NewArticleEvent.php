<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class NewArticleEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels, Queueable;

    public function __construct(public Article $article)
    {
        $this->onQueue('broadcasts');
    }

    public function broadcastOn(): Channel
    {
        return new Channel('test');
    }

    public function broadcastWith(): array
    {
        return ['article' => [
            'id' => $this->article->id,
            'title' => $this->article->title,
            'url' => route('article.show', $this->article),
        ]];
    }
}
