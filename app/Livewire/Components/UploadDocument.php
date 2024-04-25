<?php

namespace App\Livewire\Components;

use Livewire\Component;

class UploadDocument extends Component
{
    public $type;
    public function mount($type){
        $this->type = $type;
    }
    public function render()
    {
        return view('livewire.components.upload-document');
    }
}
