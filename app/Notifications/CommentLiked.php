<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;
use App\Models\Comment;

class CommentLiked extends Notification
{
    use Queueable;

    // On garde les objets utiles
    protected $liker;    // L'utilisateur qui like le commentaire
    protected $comment;  // Le commentaire liké

    /**
     * Constructeur : on reçoit l'utilisateur qui like et le commentaire concerné
     */
    public function __construct(User $liker, Comment $comment)
    {
        $this->liker = $liker;
        $this->comment = $comment;
    }

    /**
     * Les canaux utilisés pour envoyer la notification
     * Ici uniquement la base de données
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Si un jour tu veux envoyer par e-mail aussi
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Quelqu’un a liké votre commentaire')
            ->line("{$this->liker->name} a aimé l’un de vos commentaires.")
            ->action('Voir le commentaire', url("/posts/{$this->comment->post_id}#comment-{$this->comment->id}"))
            ->line('Merci de faire vivre la discussion sur notre plateforme !');
    }

    /**
     * Format de la notification en base de données
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type'        => 'like_comment',
            'user_id'     => $this->liker->id,
            'user_name'   => $this->liker->username,
            'user_avatar' => $this->liker->avatar ?? null,  // ajoute ici l’URL ou chemin de l’avatar
            'comment_id'  => $this->comment->id,
            'post_id'     => $this->comment->post_id,
            'message'     => $this->liker->first_name . " " . $this->liker->last_name . " a liké l’un de vos commentaires.",
        ];
    }
}
