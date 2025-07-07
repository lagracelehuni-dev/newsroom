<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class articleDetails extends Component
{
    /**
     * Create a new component instance.
     */
    public $post;
    public $likes;
    public $comments;

    public function __construct($post, $likes, $comments)
    {
        $this->post = $post;
        $this->likes = $likes;
        $this->comments = $comments;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.article-details');
    }
}
