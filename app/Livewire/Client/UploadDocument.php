<?php

namespace App\Livewire\Client;

use Livewire\Component;

class UploadDocument extends Component
{
    public $person;
    public function mount($person)
    {
        $this->person = $person;
    }
    public function render()
    {
        return view('livewire.client.upload-document');
    }
}
