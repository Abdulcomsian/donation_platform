<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\{EventHandler , UserHandler};
use Illuminate\Support\Facades\Validator;


class EventsController extends Controller
{
    protected $eventHandler;
    protected $userHandler;

    function __construct(EventHandler $eventHandler , UserHandler $userHandler)
    {
        $this->eventHandler = $eventHandler;
        $this->userHandler = $userHandler;
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
        $connectedId = $event->user->stripe_connected_id;
        // $setupIntent = $this->eventHandler->getStripeSetupIntent();
        
        return view('public.events.event-details')->with(['event' => $event , 'countries' => $countries, 'connectedId' => $connectedId]);
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
            dd($e->getMessage() , $e->getLine());
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
             
    }

    public function eventCreated(Request $request){
        $eventId = $request->eventId;
        return view('events.success')->with(['eventId' => $eventId]);
    }

    public function eventUpdated(Request $request){
        $eventId = $request->eventId;
        return view('events.successful-updated')->with(['eventId' => $eventId]);
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);


        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }

        try{
            $response = $this->eventHandler->purchaseTicket($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage() , 'errorLine' => $e->getLine()]);
        }
           


    }


    public function purchaseTicketList(Request $request)
    {
        $purchaseTicketStats = $this->eventHandler->getPurchaseTicketList($request);

        return view('events.purchase-ticket-list')->with(['purchaseTicketsStats' => $purchaseTicketStats , 'eventId' => $request->eventId]);
    }

    public function eventPurchaseTickets(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'eventId' => 'required|numeric',
        ]);


        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }

        return $this->eventHandler->eventPurchaseTicket($request);
    }

    public function getOrganizationEvents(Request $request)
    {
        $organizationName = $request->organizationName;

        $events = $this->eventHandler->getOrganizationEvents($request);

        $user = $this->userHandler->organizationProfile($request);

        return view('public.events.event-list')->with(['events' => $events , 'user' => $user, 'organizationName' => $organizationName]);

    }

}
