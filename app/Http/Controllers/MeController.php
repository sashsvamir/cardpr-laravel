<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;


class MeController extends Controller
{
    /**
     * Send information about current authenticated user.
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        return response([
            'user' =>  $request->user(),
        ]);
    }

}
