<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Slider extends Component
{
    public $cards;
    public $title;
    /**
     * Create a new component instance.
     */
    public function __construct($title, $cards)
    {
        $this->cards = $cards;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.slider');
    }
}
