<?php

namespace App\Livewire;

use Livewire\Component;

class WhatsappMessage extends Component
{
    public $message;
    public $payload;
    public function mount($message){
        $this->message = $message;
        $this->payload = json_decode($message->payload);
    }
    public function render()
    {
        return view('livewire.whatsapp-message');
    }
}
