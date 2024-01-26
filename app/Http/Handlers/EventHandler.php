<?php 

namespace App\Http\Handlers;
use App\Models\{Event , Country , EventFrequency , EventCategory};

class EventHandler{

    public function createEvent($request)
    {
        $event = new Event();
        $event->country_id = $request->country_id;
        $event->category_id = $request->category_id;
        $event->frequency_id = $request->frequency_id;
        $event->description = $request->description;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->venue = $request->venue;
        $event->user_id = auth()->user()->id;
        $event->organizer = $request->organizer;
        $event->featured = $request->featured;
    
        $file = $request->file('image');
        $filename =  strtotime(now()).str_replace(" ", "-" ,$file->getClientOriginalName());
        $file->move(public_path('assets/uploads') , $filename);

        $event->image = $filename;
        $event->save();

        foreach($request->tickets as $ticket){

        }

        return ['status' => true , 'msg' => 'Event Created Successfully'];
    }

    public function getEventForm()
    {
        $countries = Country::all();
        $frequencies = EventFrequency::all();
        $categories = EventCategory::all();
        return view('events.create')->with(['countries' => $countries , 'frequencies' => $frequencies , 'categories' => $categories]);
    }

    public function editEvent($request)
    {
        
    }

    public function removeEvent($request)
    {
        
    }
}