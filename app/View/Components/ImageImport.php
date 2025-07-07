<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageImport extends Component
{
    public $extraClass;
    public $inputClass;
    public $previewClass;
    public $btnClass;
    public $btnClose;
    public $name;
    public $imgSrc;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $extraClass = '',
        $inputClass = '',
        $previewClass = '',
        $btnClass = '',
        $btnClose = '',
        $name = 'image',
        $imgSrc = ''
    ) {
        $this->extraClass = $extraClass;
        $this->inputClass = $inputClass;
        $this->previewClass = $previewClass;
        $this->btnClass = $btnClass;
        $this->btnClose = $btnClose;
        $this->name = $name;
        $this->imgSrc = $imgSrc;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.image-import');
    }
}
