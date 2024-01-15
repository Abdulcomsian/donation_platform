<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function donors()
    {
        return view('donors.index');
    }

    public function donations()
    {
        return view('donations.index');
    }

    public function donateNow()
    {
        return view('public.donate.card');
    }
}
