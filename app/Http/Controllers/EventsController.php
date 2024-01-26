<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\EventHandler;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    protected $eventHandler;

    function __construct(EventHandler $eventHandler)
    {
        $this->eventHandler = $eventHandler;
    }

    public function event()
    {
        return view('events.index');
    }

    public function getEventForm()
    {
        return $this->eventHandler->getEventForm();
    }

    public function getPublicEvents()
    {
        return view('public.events.index');
    }

    public function getPublicEventDetail()
    {
        return view('public.events.event-details');
    }

    public function createEvent(Request $request){
        dd($request->tickets);
        $validator = Validator::make($request->all() , [
                        'country_id' => 'required|numeric',
                        'category_id' => 'required|numeric',
                        'frequency_id' => 'required|numeric',
                        'title' => 'required|string',
                        'description' => 'required|string',
                        'image' => 'file|required|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
                        'date' => 'required|date',
                        'time' => 'required|time',
                        'venue' => 'required|string',
                        'organizer' => 'required|string',
                        'featured' => 'nullable|boolean',
                        'ticket_name' => 'required|array|min:1',
                        'ticket_description' => 'required|array|min:1',
                        'ticket_quantity' => 'required|array|min:1',
                        'is_free' => 'required|array|min:1',
                        'ticket_amount' => 'required|array|min:1',
                    ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }
                    
        try{
            $response = $this->eventHandler->createEvent($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }


    }

    public function editEvent(Request $request){
        $validator = Validator::make($request->all() , [
            'event_id' => 'required|numeric',
            'country_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'frequency_id' => 'required|numeric',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'file|required|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
            'date' => 'required|date',
            'time' => 'required|time',
            'venue' => 'required|string',
            'organizer' => 'required|string',
            'featured' => 'nullable|boolean',
            'ticket_name' => 'required|array|min:1',
            'ticket_description' => 'required|array|min:1',
            'ticket_quantity' => 'required|array|min:1',
            'is_free' => 'required|array|min:1',
            'ticket_amount' => 'required|array|min:1',
        ]);

        
        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }
                    
        try{
            $response = $this->eventHandler->editEvent($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
             
    }

    public function eventCreated(){
        return view('events.success');
    }


    public function deleteEvent(Request $request){
        
        try{
            $id = $request->id;
            $this->eventHandler->removeEvent($id);
            \Toastr::success('Event Removed Successfully' , 'Success!');
            return redirect()->back();

        }catch(\Exception $e){
            \Toastr::error('Something Went Wrong' , 'Error!');
            \Toastr::error($e->getMessage() , 'Error!' );
            return redirect()->back();
        }

    }
}
