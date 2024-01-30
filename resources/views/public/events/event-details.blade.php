@extends('public.events.layout.detail')

@section('content')

<div class="detail">
    <div class="container-fluid rectangle">
        <div class="container top">
            <div class="logo">
                <img src="{{ asset('assets/images/Group 2 (1).png') }}" alt="">
            </div>
        </div>
        <div class="container event-content">
            <div class="img-content">
                @if($event->image)
                <img src="{{ asset('assets/uploads').'/'.$event->image }}" alt="">
                @else
                <img src="{{ asset('assets/images/EVENT.png') }}" alt="">
                @endif
            </div>
            <div class="detail-content">
                <div class="title">{{$event->title}}</div>
                <div class="date">
                    <div class="icon">
                        <img src="{{ asset('assets/images/calendar-outline (1).png') }}" alt="">
                    </div>
                    <div class="text">
                        {{\Carbon\Carbon::parse($event->date)->format('l j F, Y')}}, {{\Carbon\Carbon::parse($event->time)->format('g:i A')}}
                    </div>
                </div>
                <div class="venue">
                    <div class="icon">
                        <img src="{{ asset('assets/images/location-outline (1).png') }}" alt="">
                    </div>
                    <div class="text">
                        {{$event->venue}}
                    </div>
                </div>
                <div class="buy-btn">
                    <button>Buy Ticket</button>
                </div>
                <div class="details">
                    <p>
                        {{$event->description}}
                    </p>
                </div>
                <div class="organizer">
                    <div class="heading">Organized By:</div>
                    <div class="name">{{$event->organizer}}</div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection