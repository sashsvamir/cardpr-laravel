<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /**
     * Handle credentials.
     *
     * @return Response
     */
    public function preLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);


        // check credentials
        $credentials = $request->only('email', 'password');
        if (Auth::validate($credentials)) {
            $phone = User::whereEmail($credentials['email'])->pluck('phone')->first();

            // create token
            $sms_token = mt_rand(1000, 9999);
            $request->session()->put('sms_token', $sms_token);

            // todo: send token to phone number

            $response = [
                'phone' => substr_replace($phone, '...', 2, 6),
            ];

            if (env('APP_DEBUG', false)) {
                $response = array_merge($response, ['sms_token' => $sms_token]);
            }

            return response($response, 200);
        }

        return response([
            'message' => 'The provided credentials do not match our records.',
        ], 400);
    }

    /**
     * Handle token (authenticate).
     *
     * @return Response
     */
    public function loginWithToken(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'token' => 'required|string',
        ]);

        if ($this->validateToken($request, $request->get('token'))) {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return response(201);
            }
        }

        return response([
            'message' => 'The provided sms code do not match.',
        ], 400);
    }



    private function validateToken(Request $request, string $token)
    {
        $validToken = $request->session()->get('sms_token');
        if ($token == $validToken) {
            $request->session()->forget('sms_token');
            return true;
        } else {
            return false;
        }
    }

}
