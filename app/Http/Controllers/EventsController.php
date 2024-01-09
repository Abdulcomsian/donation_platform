<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function event()
    {
        return view('events.index');
    }

    public function getEventForm()
    {
        return view('events.create');
    }
}
