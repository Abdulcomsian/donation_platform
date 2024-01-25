<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function membership()
    {
        return view('membership.index');
    }
}
