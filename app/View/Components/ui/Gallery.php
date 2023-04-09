<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class gallery extends Component
{
    public $photos;
    public $title;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $photos)
    {
        $this->photos = $photos;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.gallery');
    }
}
