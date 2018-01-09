<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    private $guzzle;

    public function __construct(\GuzzleHttp\Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function login(Request $request)
    {
        if (!$request->has('email', 'password')) {
            abort(400);
        }

        $email = $request->get('email');
        $password = $request->get('password');

        $client = \Laravel\Passport\Client::where('name', 'librorum-frontend')->first();
        if (!$client) {
            abort(500);
        }

        $response = $this->guzzle->post(env('APP_URL') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
