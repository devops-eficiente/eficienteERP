<?php

namespace App\Livewire;

use Livewire\Component;

class WhatsappConversation extends Component
{
    public $step;
    public $messages;
    public function mount($step){
        $this->step = $step;
        $this->messages = $step->messages;
    }
    public function render()
    {

        return view('livewire.whatsapp-conversation');
    }
}
