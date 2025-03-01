<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return view('pos.users.index');
    }
}
