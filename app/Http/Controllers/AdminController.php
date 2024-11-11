<?php

namespace App\Http\Controllers;

use App\Models\WhatsappSession;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index(){
        // $user = auth()->user();
        // $whatsappSessions = WhatsappSession::where('phone', $user->phone)->with('steps', 'steps.messages')->get();
        // return $whatsappSessions;
        return view('index');
    }

    public function conversations(){
        $whatsappSessions = WhatsappSession::where('phone', auth()->user()->phone)->with('step')->get();
        return view('whatsapp.index', compact('whatsappSessions'));
    }
}
