<?php
namespace App\Http\Controllers;


use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;

class PasswordResetController
{
    /**
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email',
            'password' => ['required', 'confirmed', Rules\Password::min(6)],
        ]);

        $status = Password::reset(
            $request->only('token', 'email', 'password'),
            function (User $user, string $password) {
                // update password
                UserService::updatePassword($user, $password);

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? response(201)
            : response(['email' => __($status)], 422);
    }
}
