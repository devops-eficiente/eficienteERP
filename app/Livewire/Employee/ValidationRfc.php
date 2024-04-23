<?php

namespace App\Livewire\Employee;

use Livewire\Component;

class ValidationRfc extends Component
{
    public $step = 1;
    public $option = 'rfc_invalid';
    public function render()
    {
        return view('livewire.employee.validation-rfc');
    }

    public function addStep(){
        $this->step += 1;
    }

    public function lessStep(){
        $this->step -= 1;
    }
    // public function checkStep(){
    //     switch($this->step){
    //         case 1:
    //             # code...
    //             break;
    //         case 2:
    //             # code...
    //             break;
    //         case 3:
    //             # code...
    //             break;
    //         case 4:
    //             # code...
    //             break;
    //         default:
    //             break;
    //     }
    // }
}
