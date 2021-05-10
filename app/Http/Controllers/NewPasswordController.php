<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Passwords\PasswordBroker;


class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     * @return Response
     */
    public function __invoke(Request $request, PasswordBroker $passwordBroker)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::min(6)],
        ]);

        // get user (current)
        /** @var User $user */
        $user = $request->user();

        // check credentials
        $credentials = [
            'email' => $user->email,
            'password' => $request->get('old_password'),
        ];
        if (!Auth::validate($credentials)) {
            return response([
                'message' => 'Credentials is wrong.',
            ], 400);
        }

        // update password
        UserService::updatePassword($user, $request->get('password'));

        event(new PasswordReset($user));

        // destroy all sessions on other devices
        Auth::logoutOtherDevices($request->get('password'));

        return response(201);
    }

}
