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
        // dd("hi mana how are yo");
        $this->eventHandler = $eventHandler;
    }

    public function getEventList()
    {
        $events = $this->eventHandler->eventList();
        return view('events.index')->with(['events' => $events]);
    }

    public function getEventForm()
    {
        return $this->eventHandler->getEventForm();
    }

    public function editEventForm(Request $request)
    {
        return $this->eventHandler->getEditEventForm($request);
    }

    public function getRecentEvents(Request $request)
    {
        $distinctOrganizer = $this->eventHandler->eventOrganizer();
        $distinctVenue = $this->eventHandler->eventVenue();
        $eventCategories = $this->eventHandler->eventCategories();
        $filteredEvents = $this->eventHandler->filteredEvent($request);
       

        return view('public.events.index')->with([
                                                  'distinctOrganizer' => $distinctOrganizer , 
                                                  'distinctVenue' => $distinctVenue , 
                                                  'eventCategories' => $eventCategories,
                                                  'filteredEvents' => $filteredEvents,
                                                ]);
       
    }

    public function getEventDetail(Request $request)
    {
        $event = $this->eventHandler->eventDetail($request);
        $countries = $this->eventHandler->getCountries();
        $setupIntent = $this->eventHandler->getStripeSetupIntent();
        
        return view('public.events.event-details')->with(['event' => $event , 'countries' => $countries , 'clientSecret' => $setupIntent->client_secret]);
    }

    public function createEvent(Request $request){

        $validator = Validator::make($request->all() , [
                        'country' => 'required|numeric',
                        'category' => 'required|numeric',
                        'frequency' => 'numeric|nullable',
                        'title' => 'required|string',
                        'description' => 'required|string',
                        'image' => 'file|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
                        'date' => 'required|date',
                        'time' => 'required|date_format:H:i',
                        'venue' => 'required|string',
                        'organizer' => 'required|string',
                        'featured' => 'nullable',
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
            'country' => 'required|numeric',
            'category' => 'required|numeric',
            'frequency' => 'numeric|nullable',
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'file|mimes:jpeg,png,jpg,PNG,JPEG,JPG',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'venue' => 'required|string',
            'organizer' => 'required|string',
            'featured' => 'nullable',
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

    public function eventUpdated(Request $request){
        return view('events.successful-updated')->with(['event_id' => $request->id ?? null]);
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

    public function purchaseEventTicket(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'email' => 'required|email',
            'country' => 'required|numeric',
            'name' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }

        try{
            $response = $this->eventHandler->purchaseTicket($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
           


    }
}
