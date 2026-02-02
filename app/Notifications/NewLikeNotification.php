<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLikeNotification extends Notification
{
    use Queueable;

    protected $article;
    protected $liker;

    /**
     * Create a new notification instance.
     */
    public function __construct($article, $liker)
    {
        $this->article = $article;
        $this->liker = $liker;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'article_title' => $this->article->title,
            'article_slug' => $this->article->slug,
            'user_name' => $this->liker->name,
            'message' => 'a aimé votre article',
            'type' => 'aimerArticle'
        ];
    }
}
