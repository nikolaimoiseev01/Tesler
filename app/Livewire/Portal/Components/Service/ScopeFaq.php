<?php

namespace App\Livewire\Portal\Components\Service;

use Livewire\Component;

class ScopeFaq extends Component
{
    public $questions;
    public $halfCount;
    public function render()
    {
        $questionCount = count($this->questions);
        $this->halfCount = intdiv($questionCount, 2);

        if ($questionCount % 2 != 0) {
            $this->halfCount += 1;
        }

        return view('livewire.portal.components.service.scope-faq');
    }
}
