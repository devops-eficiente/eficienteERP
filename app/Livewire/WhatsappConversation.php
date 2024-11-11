<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;

class WhatsappConversation extends Component
{
    public $step;
    public $messages;
    public function mount($step){
        $this->step = $step;
        $this->messages = Message::where('step_id', $step->id)->get();
    }
    public function render()
    {

        return view('livewire.whatsapp-conversation');
    }
}
