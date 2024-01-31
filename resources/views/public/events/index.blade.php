@extends('public.events.layout.list-main')

@section('content')

<div class="content-pane">
    <div class="header">
        <div class="container">
            <div class="heading">
                Events
            </div>
            <div class="filters">
                <div class="form-container">
                    <form>
                        <div class="form-control">
                            <select name="category" id="category">
                                <option value="">Category</option>
                                @foreach($eventCategories as $category)
                                    <option value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <select name="venue" id="venue">
                                <option value="">Venue</option>
                                @foreach($distinctVenue as $eachVenue)
                                    <option value="{{$eachVenue->venue}}">{{$eachVenue->venue}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <select name="organizer" id="organizer">
                                <option value="">Organizer</option>
                                @foreach($distinctOrganizer as $eachOrganizer)
                                    <option value="{{$eachOrganizer->organizer}}">{{$eachOrganizer->organizer}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <button type="button" class="list-button active">
                                <i class="fas fa-list"></i>
                                {{-- <img src="{{ asset('assets/images/list-outline.png') }}" alt=""> --}}
                            </button>
                        </div>

                        <div class="form-control">
                            <button type="button" class="grid-button">
                                <i class="fas fa-th-large"></i>
                                {{-- <img src="{{ asset('assets/images/iconoir_view-grid.png') }}" alt=""> --}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="events-list">
        <div class="container">
            <div class="events-container">
                @foreach($filteredEvents as $event)
                <a class="event-item list" href="">
                    <div class="card">
                        <div class="start">
                            <div class="icon">
                                @if($event->image)
                                    <img src="{{ asset('assets/uploads').'/'.$event->image }}" alt="">
                                @else
                                    <img src="{{ asset('assets/images/Event.png') }}" alt="">
                                @endif
                            </div>
                            @if($event->featured)
                                <div class="featured">Featured</div>
                            @endif
                        </div>
                        <div class="mid">
                            <div class="title">{{$event->title}}</div>
                            <div class="description">
                                {{$event->description}}
                            </div>
                            <div class="time">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/calendar-outline.png') }}" alt="">
                                </div>
                                @php 
                                    $date = \Carbon\Carbon::parse($event->date);
                                    $time = \Carbon\Carbon::parse($event->time);
                                @endphp

                                <div class="text">{{$date->format('l j F, Y')}}, {{$time->format('g:i A')}}</div>
                            </div>
                            <div class="venue">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/location-outline.png') }}" alt="">
                                </div>
                                <div class="text">{{$event->venue}}</div>
                            </div>
                        </div>
                        <div class="end">
                            <div class="buy-button">
                                <button>Buy Ticket</button>
                            </div>
                        </div>
                    </div>
                </a>

                @endforeach

                
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {!! $filteredEvents->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    document.querySelector(".grid-button").addEventListener("click" , function(event){
        this.classList.add("active");
        document.querySelector(".list-button").classList.remove("active");
        document.querySelectorAll(".event-item").forEach(item => {
            item.classList.add("grid");
            item.classList.remove("list");
        })
        document.querySelectorAll(".events-container").forEach(item => {
            item.classList.add("has-grid");
        })

    })

    document.querySelector(".list-button").addEventListener("click" , function(event){
        this.classList.add("active");
        document.querySelector(".grid-button").classList.remove("active");
        document.querySelectorAll(".event-item").forEach(item => {
            item.classList.add("list");
            item.classList.remove("grid");
        })
        document.querySelectorAll(".events-container").forEach(item => {
            item.classList.remove("has-grid");
        })
    })

    $(document).ready(function(){
        $("#category").select2()
        $("#organizer").select2()
        $("#venue").select2()
    })


</script>
@endsection