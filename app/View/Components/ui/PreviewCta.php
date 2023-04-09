<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PreviewCta extends Component
{
    public $cards;
    public $title;
    public $link;



    /**
     * Create a new component instance.
     */
    public function __construct($cards, $title, $link)
    {
        $this->cards = $cards;
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.preview-cta');
    }
}
