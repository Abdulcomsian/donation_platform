<?php

namespace App\Http\Controllers;

class SettingController extends Controller
{
    public function settings()
    {
        return view('settings.index');
    }
}
