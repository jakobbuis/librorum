<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
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

        try {
            return $this->generateToken($email, $password);
        }
        catch (ClientException $e) {
            return response(null, 401);
        }
    }

    /**
     * Construct a full token request based on the email and password
     * @param  string $email
     * @param  string $password
     * @return object
     */
    private function generateToken(string $email, string $password)
    {
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
