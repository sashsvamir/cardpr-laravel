<?php
namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class SessionDestroyController extends Controller
{
    /**
     * @return Response
     */
    public function __invoke(Session $session)
    {
        $session->delete();

        return response(201);
    }


}
