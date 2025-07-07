<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ComposeUpdate extends Component
{
    /**
     * Create a new component instance.
     */
    public $post;
    public Collection $categories;

    public function __construct($post, Collection $categories)
    {
        $this->post = $post;
        $this->categories = $categories;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.compose-update');
    }
}
