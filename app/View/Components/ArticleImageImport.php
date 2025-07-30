<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ArticleImageImport extends Component
{
    public $name;
    public $previewClass;
    public $btnClass;
    public $extraClass;
    public $btnClose;

    public function __construct($name = 'image', $previewClass = 'image-import__preview', $btnClass = 'image-import__browse', $extraClass = 'image-import', $btnClose = 'image-import__close')
    {
        $this->name = $name;
        $this->previewClass = $previewClass;
        $this->btnClass = $btnClass;
        $this->extraClass = $extraClass;
        $this->btnClose = $btnClose;
    }

    public function render()
    {
        return view('components.article-image-import');
    }
} 