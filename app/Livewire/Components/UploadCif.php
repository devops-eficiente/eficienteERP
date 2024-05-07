<?php

namespace App\Livewire\Components;

use Livewire\Component;

class UploadCif extends Component
{
    public $type,$url;
    public function mount($type){
        $this->type = $type;
        if($type == 'employee'){
            $this->url = route('admin.employee.createByData');
        }else{
            $this->url = route('admin.client.createByData');
        }
    }
    public function render()
    {
        return view('livewire.components.upload-cif');
    }
}
