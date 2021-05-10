<?php
namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;


class AddUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::min(7)],
        ]);

        $user = UserService::create($request->phone, $request->email, $request->password);

        event(new Registered($user));

        // Auth::login($user);

        return response(201);
    }

}
