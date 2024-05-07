<?php

namespace App\Livewire\Components;

use Livewire\Component;

class UploadDocument extends Component
{
    public $type,$url;
    public function mount($type){
        $this->type = $type;
        if($type == 'employee'){
            $this->url = route('admin.employee.createByDocument');
        }else{
            $this->url = route('admin.client.createByDocument');
        }
    }
    public function render()
    {

        return view('livewire.components.upload-document');
    }
}
