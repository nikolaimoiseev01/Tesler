<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NeedConsultation extends Component
{
    public $imgLink;
    /**
     * Create a new component instance.
     */
    public function __construct($imgLink=null)
    {
        $this->imgLink = $imgLink ?? config('cons.default_pic');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.need-consultation');
    }
}
