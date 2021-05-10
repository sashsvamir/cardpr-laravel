<?php
namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class SessionsController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return response([
            'sessions' => $user->sessions,
            'current_id' => $request->session()->getId(),
        ]);
    }

}
