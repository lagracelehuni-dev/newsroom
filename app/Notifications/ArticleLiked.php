<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue; // Pour gérer les files (non utilisé ici mais utile plus tard)
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;
use App\Models\Post;

class ArticleLiked extends Notification
{
    use Queueable;

    // On définit deux propriétés pour conserver les données nécessaires à la notification
    protected $liker; // L'utilisateur qui a liké
    protected $post;  // L'article liké

    /**
     * Le constructeur reçoit l'utilisateur qui a liké et l'article liké
     */
    public function __construct(User $liker, Post $post)
    {
        $this->liker = $liker;
        $this->post = $post;
    }

    /**
     * Détermine les canaux de diffusion de la notification.
     * Ici on utilise uniquement la base de données.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Représentation de la notification si on veut l'envoyer par mail (non utilisé ici).
     * Tu peux l'activer plus tard si tu veux notifier aussi par email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre article a été liké !')
            ->line("{$this->liker->name} a aimé votre article : {$this->post->title}.")
            ->action('Voir l’article', url("/posts/{$this->post->id}"))
            ->line('Merci d’utiliser notre plateforme !');
    }

    /**
     * Représentation de la notification pour la base de données.
     * C'est ce qui sera enregistré dans la table `notifications`.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type'      => 'like_article', // Pour filtrer plus tard si besoin
            'user_id'   => $this->liker->id, // ID du liker
            'user_name' => $this->liker->username,
            'user_avatar' => $this->liker->avatar ?? null,  // ajoute ici l’URL ou chemin de l’avatar
            'post_id'   => $this->post->id,
            'post_title'=> $this->post->title,
            'message'   => $this->liker->first_name . " " . $this->liker->last_name . " a liké votre article « ". $this->post->title . " ».",
        ];
    }
}
