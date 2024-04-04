<?php

namespace App\Livewire\Employee;

use Livewire\Component;

class UploadCif extends Component
{
    public $employee;
    public function mount($employee)
    {
        $this->employee = $employee;
    }
    public function render()
    {
        return view('livewire.employee.upload-cif');
    }
}
