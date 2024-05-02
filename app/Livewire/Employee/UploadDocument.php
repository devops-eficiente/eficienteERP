<?php

namespace App\Livewire\Employee;

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
        return view('livewire.employee.upload-document');
    }
}
