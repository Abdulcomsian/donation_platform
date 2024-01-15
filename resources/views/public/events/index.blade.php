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
                            </select>
                        </div>
                        <div class="form-control">
                            <select name="venue" id="venue">
                                <option value="">Venue</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <select name="organizer" id="organizer">
                                <option value="">Organizer</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <button type="button">
                                <img src="{{ asset('assets/images/list-outline.png') }}" alt="">
                            </button>
                        </div>

                        <div class="form-control">
                            <button type="button">
                                <img src="{{ asset('assets/images/iconoir_view-grid.png') }}" alt="">
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
                <a class="event-item" href="">
                    <div class="card">
                        <div class="start">
                            <div class="icon">
                                <img src="{{ asset('assets/images/d3f7e3dc434bdc4136496a06f562ac81.jpeg') }}" alt="">
                            </div>

                            <div class="featured">Featured</div>
                        </div>
                        <div class="mid">
                            <div class="title">Event Title</div>
                            <div class="description">
                                Lorem ipsum dolor sit amet consectetur. Venenatis ornare sit scelerisque sit. Dapibus
                                quisque volutpat varius ante leo sdfv dfv dfv dsfvsd fvs dfv sdfv sdfvs dfvsdfvsdfvs
                                dfvs dfvsdfvsdfvsdfvs dfvsdf vsdfv sdfvsdf v
                            </div>
                            <div class="time">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/calendar-outline.png') }}" alt="">
                                </div>
                                <div class="text">Saturday 13 January, 2024 6:30 PM</div>
                            </div>
                            <div class="venue">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/location-outline.png') }}" alt="">
                                </div>
                                <div class="text">Venue Here</div>
                            </div>
                        </div>
                        <div class="end">
                            <div class="buy-button">
                                <button>Buy Ticket</button>
                            </div>
                        </div>
                    </div>
                </a>

                <a class="event-item" href="">
                    <div class="card">
                        <div class="start">
                            <div class="icon">
                                <img src="{{ asset('assets/images/d3f7e3dc434bdc4136496a06f562ac81.jpeg') }}" alt="">
                            </div>

                            <div class="featured">Featured</div>
                        </div>
                        <div class="mid">
                            <div class="title">Event Title</div>
                            <div class="description">
                                Lorem ipsum dolor sit amet consectetur. Venenatis ornare sit scelerisque sit. Dapibus
                                quisque volutpat varius ante leo sdfv dfv dfv dsfvsd fvs dfv sdfv sdfvs dfvsdfvsdfvs
                                dfvs dfvsdfvsdfvsdfvs dfvsdf vsdfv sdfvsdf v
                            </div>
                            <div class="time">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/calendar-outline.png') }}" alt="">
                                </div>
                                <div class="text">Saturday 13 January, 2024 6:30 PM</div>
                            </div>
                            <div class="venue">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/location-outline.png') }}" alt="">
                                </div>
                                <div class="text">Venue Here</div>
                            </div>
                        </div>
                        <div class="end">
                            <div class="buy-button">
                                <button>Buy Ticket</button>
                            </div>
                        </div>
                    </div>
                </a>

                <a class="event-item" href="">
                    <div class="card">
                        <div class="start">
                            <div class="icon">
                                <img src="{{ asset('assets/images/d3f7e3dc434bdc4136496a06f562ac81.jpeg') }}" alt="">
                            </div>
                        </div>
                        <div class="mid">
                            <div class="title">Event Title</div>
                            <div class="description">
                                Lorem ipsum dolor sit amet consectetur. Venenatis ornare sit scelerisque sit. Dapibus
                                quisque volutpat varius ante leo sdfv dfv dfv dsfvsd fvs dfv sdfv sdfvs dfvsdfvsdfvs
                                dfvs dfvsdfvsdfvsdfvs dfvsdf vsdfv sdfvsdf v
                            </div>
                            <div class="time">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/calendar-outline.png') }}" alt="">
                                </div>
                                <div class="text">Saturday 13 January, 2024 6:30 PM</div>
                            </div>
                            <div class="venue">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/location-outline.png') }}" alt="">
                                </div>
                                <div class="text">Venue Here</div>
                            </div>
                        </div>
                        <div class="end">
                            <div class="buy-button">
                                <button>Buy Ticket</button>
                            </div>
                        </div>
                    </div>
                </a>

                <a class="event-item" href="">
                    <div class="card">
                        <div class="start">
                            <div class="icon">
                                <img src="{{ asset('assets/images/d3f7e3dc434bdc4136496a06f562ac81.jpeg') }}" alt="">
                            </div>
                        </div>
                        <div class="mid">
                            <div class="title">Event Title</div>
                            <div class="description">
                                Lorem ipsum dolor sit amet consectetur. Venenatis ornare sit scelerisque sit. Dapibus
                                quisque volutpat varius ante leo sdfv dfv dfv dsfvsd fvs dfv sdfv sdfvs dfvsdfvsdfvs
                                dfvs dfvsdfvsdfvsdfvs dfvsdf vsdfv sdfvsdf v
                            </div>
                            <div class="time">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/calendar-outline.png') }}" alt="">
                                </div>
                                <div class="text">Saturday 13 January, 2024 6:30 PM</div>
                            </div>
                            <div class="venue">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/location-outline.png') }}" alt="">
                                </div>
                                <div class="text">Venue Here</div>
                            </div>
                        </div>
                        <div class="end">
                            <div class="buy-button">
                                <button>Buy Ticket</button>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection