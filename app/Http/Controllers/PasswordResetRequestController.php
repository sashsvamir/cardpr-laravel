<?php
namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;


class PasswordResetRequestController
{
    /**
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        // create and store password recover token in db
        $token = '';
        $status = Password::sendResetLink(
            $request->only('email'),
            function (User $user, string $new_token) use (&$token) {
                // todo: send token by email (throw fire event)
                $token = $new_token;
                // $user->sendPasswordResetNotification($token); // see: Illuminate\Auth\Notifications\ResetPassword
            }
        );

        // if wrong creating token
        if ($status !== Password::RESET_LINK_SENT) {
            return response([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'email' => [__($status)]
                ],
            ], 422);
        }

        // success response
        if (env('APP_DEBUG', false)) {
            return response(['token' => $token], 200);
        }
        return response(204);
    }
}
