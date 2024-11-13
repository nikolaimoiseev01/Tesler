<?php

namespace App\View\Components\ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NeedConsultation extends Component
{
    public $imglink;
    /**
     * Create a new component instance.
     */
    public function __construct($imglink=null)
    {
        $this->imglink = 'test';
//        $default_link = config('cons.default_pic');
//        if(is_null($imglink)) {
//            $this->imglink = 'test';
//        }
//        if($imglink <> '') {
//            $this->imgLink = $imglink;
//        } else {
//            $this->imgLink = $default_link;
//        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        dd(123);
        return view('components.ui.need-consultation', [
            'imglink' => $this->imglink
        ]);
    }
}
