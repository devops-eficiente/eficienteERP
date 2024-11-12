<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WhatsappSession;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
    {
        // $user = auth()->user();
        // $whatsappSessions = WhatsappSession::where('phone', $user->phone)->with('steps', 'steps.messages')->get();
        // return $whatsappSessions;
        return view('index');
    }

    public function conversations()
    {
        $whatsappSessions = WhatsappSession::where('phone', auth()->user()->phone)->with('step')->get();
        return view('whatsapp.index', compact('whatsappSessions'));
    }

    public function send_notification($id)
    {
        $user = User::find($id);
        $client = new Client();
        $response = $client->post('https://api.gupshup.io/wa/api/v1/template/msg', [
            'headers' => [
                'accept' => 'application/json',
                'Cache-Control' => 'no-cache',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'apikey' => config('app.gupshup_apikey')
            ],
            'form_params' => array_merge(
                [
                    'channel' => 'whatsapp',
                    'source' => config('app.gupshup_source'),
                    'src.name' => config('app.gupshup_appname'),
                ],
                [
                    'destination' => '521' . $user->phone,
                    'template' => json_encode([
                        'id' => '459acaa5-b691-4228-9489-15b6f84f4006',
                        'params' => [$user->name],
                    ]),
                ]
            )
        ]);

        if($response->getStatusCode() == 200) {
            return back()->with('success', 'Notificación enviada');
        }else{
            return back()->with('error', 'Error al enviar la notificación');
        }
    }
}
