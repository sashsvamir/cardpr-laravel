<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginSimpleController extends Controller
{
    /**
     * Handle token (authenticate).
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // check credentials
        if ( ! Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'The provided sms code do not match.',
            ], 400);
        }

        $request->session()->regenerate();

        return response(201);
    }

}
