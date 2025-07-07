<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;
use App\Models\Comment;

class CommentReplied extends Notification
{
    use Queueable;

    // Utilisateur qui répond et commentaire d’origine
    protected $replier;       // Celui qui répond
    protected $parentComment; // Le commentaire auquel on a répondu
    protected $reply;         // La réponse

    /**
     * Le constructeur reçoit :
     * - l'utilisateur qui répond
     * - le commentaire initial
     * - la réponse créée
     */
    public function __construct(User $replier, Comment $parentComment, Comment $reply)
    {
        $this->replier = $replier;
        $this->parentComment = $parentComment;
        $this->reply = $reply;
    }

    /**
     * Canaux utilisés pour la notification
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Représentation e-mail de la notification (optionnel)
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Quelqu’un a répondu à votre commentaire')
            ->line("{$this->replier->name} a répondu à votre commentaire.")
            ->action('Voir la réponse', url("/posts/{$this->reply->post_id}#comment-{$this->reply->id}"))
            ->line('Merci pour votre participation active à la discussion !');
    }

    /**
     * Représentation dans la base de données
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type'             => 'reply_comment',
            'user_id'          => $this->replier->id,
            'user_name'        => $this->replier->username,
            'user_avatar'       => $this->replier->avatar ?? null,  // ajoute ici l’URL ou chemin de l’avatar
            'reply_id'         => $this->reply->id,
            'parent_comment_id'=> $this->parentComment->id,
            'post_id'          => $this->reply->post_id,
            'message'          => $this->replier->first_name . " " . $this->replier->last_name . " a répondu à l’un de vos commentaires.",
        ];
    }
}
