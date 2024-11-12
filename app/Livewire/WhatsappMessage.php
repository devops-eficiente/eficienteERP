<?php

namespace App\Livewire;

use Livewire\Component;

class WhatsappMessage extends Component
{
    public $message;
    public $payload;
    public function mount($message){
        $this->message = $message;
        // dd($message);
        $this->payload = $message->payload ;
    }
    public function render()
    {
        return view('livewire.whatsapp-message');
    }
}
