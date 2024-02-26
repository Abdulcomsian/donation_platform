<?php 

namespace App\Http\Handlers;
use App\Models\{Event , Country , EventFrequency , EventCategory , EventTicket , User, UserTicket};
use Illuminate\Support\Facades\DB;
use Stripe\{ Stripe , SetupIntent , Transfer};
use Yajra\DataTables\DataTables;
class EventHandler{

    public function createEvent($request)
    {
        $event = new Event();
        $event->country_id = $request->country;
        $event->category_id = $request->category;
        $event->frequency_id = $request->frequency;
        $event->description = $request->description;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->venue = $request->venue;
        $event->user_id = auth()->user()->hasRole('admin') || auth()->user()->hasRole('owner') ? auth()->user()->id : \Helper::getOrganizationOwnerId();
        $event->created_by = auth()->user()->id;
        $event->organizer = $request->organizer;
        $event->featured = $request->featured == "on" ? 1 : 0;


        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename =  strtotime(now()).str_replace(" ", "-" ,$file->getClientOriginalName());
            $file->move(public_path('assets/uploads') , $filename);
            $event->image = $filename;
        }

        $event->save();
        $tickets = json_decode($request->tickets);
        foreach($tickets as $ticket){

            $newTicket = new EventTicket();
            $newTicket->event_id = $event->id;
            $newTicket->name = $ticket->name;
            $newTicket->description = $ticket->description;
            $newTicket->quantity = $ticket->quantity;
            $newTicket->is_free = $ticket->isFree;
            $newTicket->price = $ticket->amount;

            $ticketNameArray = explode(" " , $ticket->name);
            $prefixArray = [];
            foreach($ticketNameArray as $string){
                $prefixArray[] = substr(strtoupper($string), 0 ,1);
            }
            
            $ticket->generated_id = implode("" , $prefixArray)."-".$event->id;
            $newTicket->save();
        }

        return ['status' => true , 'msg' => 'Event Created Successfully' , 'paramId' => $event->id];
    }

    public function editEvent($request)
    {
        DB::beginTransaction();

        $event = Event::where('id' , $request->event_id)->first();
        $event->country_id = $request->country;
        $event->category_id = $request->category;
        $event->frequency_id = $request->frequency;
        $event->description = $request->description;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->venue = $request->venue;
        $event->organizer = $request->organizer;
        $event->featured = $request->featured == "on" ? 1 : 0;
        $event->save();

        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename =  strtotime(now()).str_replace(" ", "-" ,$file->getClientOriginalName());
            $file->move(public_path('assets/uploads') , $filename);
            $event->image = $filename;
        }

        $event->save();
        $tickets = json_decode($request->tickets);

        foreach($tickets as $ticket)
        {
            if(isset($ticket->id) && !empty($ticket->id)){

                $prevTicket = EventTicket::with('users')->where('id' , $ticket->id)->first();

                $purchasedTickets = 0;
                foreach($prevTicket->users as $ticketPurchaser){
                    $purchasedTickets += $ticketPurchaser->pivot->quantity;
                }

                if($ticket->quantity < $purchasedTickets){
                    DB::rollBack();
                    return ['status' => false , 'msg' => 'Already Ticket Sold More Then Quantity'];
                }

                $prevTicket->name = $ticket->name;
                $prevTicket->description = $ticket->description;
                $prevTicket->quantity = $ticket->quantity;
                $prevTicket->is_free = $ticket->isFree;
                $prevTicket->price = $ticket->amount;

                $ticketNameArray = explode(" " , $ticket->name);
                $prefixArray = [];

                foreach($ticketNameArray as $string){
                    $prefixArray[] = substr(strtoupper($string), 0 ,1);
                }
                $prevTicket->generated_id = implode("" , $prefixArray)."-".$event->id;
                $prevTicket->save();
                
            }else{
                $newTicket = new EventTicket();
                $newTicket->event_id = $event->id;
                $newTicket->name = $ticket->name;
                $newTicket->description = $ticket->description;
                $newTicket->quantity = $ticket->quantity;
                $newTicket->is_free = $ticket->isFree;
                $newTicket->price = $ticket->amount;
    
                $ticketNameArray = explode(" " , $ticket->name);
                $prefixArray = [];
                foreach($ticketNameArray as $string){
                    $prefixArray[] = substr(strtoupper($string), 0 ,1);
                }
                
                $ticket->generated_id = implode("" , $prefixArray)."-".$event->id;
                $newTicket->save();
            }
        }

        DB::commit();

        return ['status' => true , 'msg' => 'Event Updated Successfully' , 'paramId' => $event->id];

    }

    public function getEventForm()
    {
        $countries = Country::all();
        $frequencies = EventFrequency::all();
        $categories = EventCategory::all();
        return view('events.create')->with(['countries' => $countries , 'frequencies' => $frequencies , 'categories' => $categories]);
    }

    public function getEditEventForm($request)
    {
        $event = Event::with('country' , 'category' , 'frequency' , 'ticket.users')->where('id' , $request->id)->first();
        $countries = Country::all();
        $frequencies = EventFrequency::all();
        $categories = EventCategory::all();
        return view('events.edit')->with(['event' => $event  , 'countries' => $countries , 'frequencies' => $frequencies , 'categories' => $categories]);
    }

    public function eventList(){
        $events = null;
        if(auth()->user()->hasRole('admin')){
            $events = Event::with('ticket.users')->orderBy('id' , 'desc')->paginate(10);
        }else{
            if(auth()->user()->hasRole('owner')){
                $events = Event::with('ticket.users')->where('user_id' , auth()->user()->id)->orderBy('id' , 'desc')->paginate(10);
            }else{
                $events = Event::with('ticket.users')->where('created_by' , auth()->user()->id)->orderBy('id' , 'desc')->paginate(10);
            }

        }
        return $events;
    }


    public function eventDetail($request)
    {
        $event = Event::with('country' , 'category' , 'frequency' , 'ticket.users')->where('id' , $request->id)->first();
        return $event;
    }

    public function getCountries(){
        $countries = Country::all();
        return $countries;
    }

    public function eventOrganizer()
    {
        $distinctOrganizer = DB::table('events')->select('organizer')->distinct()->get();
        return $distinctOrganizer;
    }
    
    public function eventVenue()
    {   
        $distinctVenue = DB::table('events')->select('venue')->distinct()->get();
        return $distinctVenue;
    }

    public function eventCategories()
    {
        $eventCategories = EventCategory::all();
        return $eventCategories;
    }

    public function filteredEvent($request)
    {
        $category = $request->category;
        $venue = $request->venue;
        $organizer = $request->organizer;
        $currentDate = now();
        $query = Event::query();

        $query->when(isset($category) && !empty($category), function($query) use($category){
            $query->where('category_id' , $category);
        });

        $query->when(isset($venue) && !empty($venue), function($query) use($venue){
            $query->where('venue' , 'like' ,  '%'.$venue.'%');
        });

        $query->when(isset($organizer) && !empty($organizer), function($query) use($organizer){
            $query->where('organizer' , 'like' , '%'.$organizer.'%');
        });
        
        $query->where('date', '>=' , $currentDate);
        
        $events = $query->orderBy('date' , 'asc')->paginate(10)->appends([
                        'category' => $category,
                        'venue' => $venue,
                        'organizer' => $organizer,
                    ]); 
        
        return $events;

    }

    public function getStripeSetupIntent()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $setupIntent = SetupIntent::create(['usage' => 'on_session']);
        return $setupIntent;
    }

    public function purchaseTicket($request)
    {
        $tickets =  $request->tickets;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $eventId = $request->event_id;


        $user = User::where('email' , $email)->first();
        $subTotal = $request->subtotal;

        if(!$user){
            $user = new User;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->email = $email;
            $user->save();
        }

        if(!$user->hasRole('ticket_purchaser'))
        {
            $user->assignRole('ticket_purchaser');
        }

        $transfer = null;

        if($subTotal > 0)
        {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $connectedAccountId = Event::with('user')->where('id' , $eventId)->first()->user->stripe_connected_id;
        

            $transfer = Transfer::create([
                'amount' => $subTotal * 100,
                'currency' => 'usd',
                'destination' => $connectedAccountId,
            ]);

            \Helper::sendMail(\AppConst::EVENT_REGISTRATION , $request->email , $user->id);
            // if(!$user->hasStripeId())
            // {
            //     $user->createAsStripeCustomer();
            // }

            // $user->updateDefaultPaymentMethod($request->paymentMethod);

            // $intent = PaymentIntent::create([
            //     'amount' => $subTotal * 100,
            //     'currency' => 'usd',
            //     'customer' => $user->stripe_id,
            //     'payment_method' => $request->paymentMethod,
            //     'description' => 'Donation Platform Ticket Charge',
            //     'confirmation_method' => 'automatic', 
            // ]);
    
        }

        $purchaseTickets = []; 

        foreach($tickets as $ticket){
            $ticketQuantity = $ticket['quantity'];
            $ticketId = $ticket['id'];
            $purchaseTickets[] = ["user_id" => $user->id , "ticket_id" => $ticketId , "quantity" => $ticketQuantity , "stripe_id" => isset($transfer) ? $transfer->id : null];
        }

        UserTicket::insert($purchaseTickets);

        return ["status" => true , 'msg' => 'Ticket Purchased Successfully'];

    }

    public function removeEvent($request)
    {
        
    }

    public function totalTicketCount()
    {
        $eventTicketCount = 0;
        $query = EventTicket::query();

        $query->when(!auth()->user()->hasRole('admin') , function($query1) {

            $query1->when(auth()->user()->hasRole('fundraiser') || auth()->user()->hasRole('organization_admin') , function($query2){
                $query2->whereHas('event' , function($query3){
                    $query3->where('created_by' , auth()->user()->id); 
                });
            });

            $query1->when(auth()->user()->hasRole('owner'), function($query2){
                $query2->whereHas('event' , function($query3){
                    $query3->where('user_id' , auth()->user()->id); 
                });
            });

        });

        $eventTickets = $query->with('users')->get();

        foreach($eventTickets as $ticket)
        {
            foreach($ticket->users as $user)
            {
                $eventTicketCount += $user->pivot->quantity;
            }
        }
        
        return $eventTicketCount;

    }

    public function getPurchaseTicketList($request)
    {
        $eventTickets = EventTicket::with('users' , 'event')->where('event_id' , $request->eventId)->get();
        
        return $eventTickets;
    }

    public function eventPurchaseTicket($request)
    {
        $eventId = $request->eventId;

        $purchaseTickets = UserTicket::with('user' , 'ticket')->whereHas('ticket' , function($query) use($eventId){
            $query->where('event_id' , $eventId);
        })->get();


        return DataTables::of($purchaseTickets)
              ->addIndexColumn()
              ->addColumn('ticket_name' , function($ticket){
                return $ticket->ticket->name;
              })
              
              ->addColumn('user_name' , function($ticket){
                return $ticket->user->first_name.' '.$ticket->user->last_name;
              })
              ->addColumn('email' , function($ticket){
                return $ticket->user->email;
              })
              ->addColumn('quantity' , function($ticket){
                return $ticket->quantity;
              })
              ->addColumn('amount' , function($ticket){
                return $ticket->ticket->price > 0 ? '$'.number_format($ticket->ticket->price , 2) : 'free';
              })
              ->addColumn('total' , function($ticket){
                return $ticket->ticket->price == 0 ? '$0' : '$'. number_format($ticket->quantity * $ticket->ticket->price , 2);   
              })
              ->rawColumns(['ticket_name' , 'user_name' , 'email' ,'quantity' , 'amount' , 'total'])
              ->make(true);

    }

    public function getOrganizationEvents($request)
    {
        $id = \Crypt::decrypt($request->id);
        
        $events = Event::where('user_id' , $id)->orderby('created_at' , 'desc')->paginate(10);

        return $events;
    }

}