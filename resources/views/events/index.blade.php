@extends('layouts.dashboard.main')

@section('stylesheets')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;0,1000;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900;1,1000&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/event.css') }}">

@endsection

@section('content')
<div class="events">
    <div class="header">
        <div class="heading">Events</div>
        <div class="create-campaign">
            <a href="{{ route('event.create.form') }}">Create New Events</a>
        </div>
    </div>

    <div class="data-cards">
        <div class="row">

            @foreach($events as $event)
            <div class="col-md-4">
                <div class="card">
                    <div class="top">
                        <div class="heading">
                            <div class="text"><a href="{{url('event-detail' , $event->id)}}">{{$event->title}}</a></div>
                            <div class="menu">
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <img src="{{ asset('assets/images/ellipsis-vertical-sharp.png') }}" alt="">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{url('event-detail' , $event->id)}}">View</a></li>
                                        <li><a class="dropdown-item" href="{{url('events/edit-event' , $event->id)}}">Edit</a></li>
                                        <li><a class="dropdown-item" href="{{url('events/delete-event' , $event->id)}}">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="sub-heading">{{\Str::limit($event->description, 28, '...')}}</div>
                        <div class="info">
                            <div class="days-ago">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"
                                        fill="none">
                                        <path
                                            d="M7.46102 1.61426C4.23857 1.61426 1.62769 4.22514 1.62769 7.44759C1.62769 10.67 4.23857 13.2809 7.46102 13.2809C10.6835 13.2809 13.2944 10.67 13.2944 7.44759C13.2944 4.22514 10.6835 1.61426 7.46102 1.61426ZM9.63652 8.97649L9.16609 9.56453C9.13522 9.60312 9.09705 9.63526 9.05375 9.65911C9.01046 9.68295 8.9629 9.69803 8.91377 9.70349C8.86465 9.70895 8.81493 9.70469 8.76746 9.69093C8.71999 9.67718 8.67569 9.65421 8.63709 9.62333L7.06115 8.45384C6.95104 8.36568 6.86216 8.25389 6.80108 8.12673C6.74001 7.99958 6.70831 7.86032 6.70833 7.71926V4.06049C6.70833 3.96068 6.74798 3.86496 6.81856 3.79438C6.88914 3.7238 6.98486 3.68415 7.08467 3.68415H7.83736C7.93718 3.68415 8.0329 3.7238 8.10348 3.79438C8.17406 3.86496 8.21371 3.96068 8.21371 4.06049V7.44759L9.57795 8.44725C9.61657 8.47815 9.64872 8.51634 9.67256 8.55967C9.6964 8.60299 9.71148 8.65058 9.71691 8.69973C9.72235 8.74888 9.71805 8.79862 9.70426 8.84611C9.69046 8.8936 9.66745 8.9379 9.63652 8.97649Z"
                                            fill="#CBCBCB" />
                                    </svg>
                                </div>
                                @php 
                                $eventDate = \Carbon\Carbon::createFromDate($event->date);
                                $currentDate = \Carbon\Carbon::now();
                                $diffInDays = $eventDate->diffInDays($currentDate);
                                
                                @endphp
                                <div class="text">{{$diffInDays}} Days Ago</div>
                            </div>
                            <div class="amount">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                                        fill="none">
                                        <g clip-path="url(#clip0_292_832)">
                                            <path
                                                d="M10.1624 3.97391L9.90596 4.23031C9.77542 4.36085 9.59838 4.43418 9.41377 4.43418C9.22916 4.43418 9.05212 4.36085 8.92158 4.23031C8.79105 4.09978 8.71771 3.92273 8.71771 3.73812C8.71771 3.55352 8.79105 3.37647 8.92158 3.24594L9.17799 2.98953L7.54393 1.35547L5.48143 3.41797L5.38768 3.70133L5.10432 3.79508L0.547363 8.35203L2.18236 9.98703L2.43877 9.73063C2.56931 9.60009 2.74635 9.52675 2.93096 9.52675C3.11556 9.52675 3.29261 9.60009 3.42314 9.73063C3.55368 9.86116 3.62702 10.0382 3.62702 10.2228C3.62702 10.4074 3.55368 10.5845 3.42314 10.715L3.16674 10.9714L4.8008 12.6055L9.35705 8.04922L9.4508 7.76586L9.73416 7.67211L11.7967 5.60961L10.1624 3.97391ZM5.27424 4.10117L5.78682 3.58859L6.56025 4.36203L6.04744 4.87461L5.27424 4.10117ZM6.28205 5.10898L6.79486 4.59617L7.55705 5.35836L7.04424 5.87117L6.28205 5.10898ZM7.27955 6.10648L7.79236 5.59367L8.55455 6.35586L8.04268 6.86984L7.27955 6.10648ZM9.05072 7.87742L8.27729 7.10398L8.78986 6.59117L9.5633 7.36461L9.05072 7.87742Z"
                                                fill="#CBCBCB" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_292_832">
                                                <rect width="12" height="12" fill="white" transform="translate(0.172363 0.980469)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                @php
                                    $soldTicketCount = 0;
                                    foreach($event->ticket as $ticket){
                                        $soldTicketCount += $ticket->users->count();
                                    }
                                @endphp
                                <div class="text">{{$soldTicketCount}} Tickets Sold</div>
                            </div>
                        </div>
                    </div>
                    <div class="middle">
                        @if($event->image)
                            <img src="{{ asset('assets/uploads').'/'.$event->image }}" alt="">
                        @else
                            <img src="{{ asset('assets/images/EVENT.png') }}" alt="">
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

            <div class="container">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        {!! $events->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection