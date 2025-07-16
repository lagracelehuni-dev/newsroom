<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue; // Pour la mise en file (future optimisation)
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class ArticleCommented extends Notification
{
    use Queueable;

    // On garde les objets nécessaires
    protected $commenter; // L'utilisateur qui a commenté
    protected $post;      // L'article concerné
    protected $comment;   // Le commentaire

    /**
     * Constructeur avec les données utiles pour la notification
     */
    public function __construct(User $commenter, Post $post, Comment $comment)
    {
        $this->commenter = $commenter;
        $this->post = $post;
        $this->comment = $comment;
    }

    /**
     * Canaux de diffusion de la notification.
     * Ici : base de données uniquement.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Notification par e-mail (pas utilisée ici, mais prête au cas où).
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau commentaire sur votre article')
            ->line("{$this->commenter->name} a commenté votre article : {$this->post->title}")
            ->action('Voir le commentaire', url("/posts/{$this->post->id}#comment-{$this->comment->id}"))
            ->line('Merci d’utiliser notre application !');
    }

    /**
     * Notification enregistrée dans la base de données.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'comment_article',
            'user_id'     => $this->commenter->id,
            'user_name'   => $this->commenter->username,
            'user_avatar' => $this->commenter->avatar ?? null,  // ajoute ici l’URL ou chemin de l’avatar
            'post_id'     => $this->post->id,
            'post_title'  => $this->post->title,
            'comment_id'  => $this->comment->id,
            'message'     => $this->comment->user->first_name . " " . $this->comment->user->last_name . " a commenté votre article « ". $this->post->title . " ».",
        ];
    }
}
