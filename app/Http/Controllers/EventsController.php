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

    public function getPublicEvents()
    {
        return view('public.events.index');
    }

    public function getPublicEventDetail()
    {
        return view('public.events.event-details');
    }
}
