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
                <img src="{{ asset('assets/images/d3f7e3dc434bdc4136496a06f562ac81.jpeg') }}" alt="">
            </div>
            <div class="detail-content">
                <div class="title">Event Title</div>
                <div class="date">
                    <div class="icon">
                        <img src="{{ asset('assets/images/calendar-outline (1).png') }}" alt="">
                    </div>
                    <div class="text">
                        Saturday 13 January, 2024 6:30 PM
                    </div>
                </div>
                <div class="venue">
                    <div class="icon">
                        <img src="{{ asset('assets/images/location-outline (1).png') }}" alt="">
                    </div>
                    <div class="text">
                        Venue Here
                    </div>
                </div>
                <div class="buy-btn">
                    <button>Buy Ticket</button>
                </div>
                <div class="details">
                    <p>
                        Lorem ipsum dolor sit amet consectetur. Mauris viverra tortor scelerisque arcu. Vitae magna a vulputate et augue. Commodo mattis aliquam natoque turpis. Mattis netus sed magna nibh. Lectus pretium nunc nunc mi et id ac eu vulputate.

                        Amet in fusce eget velit rutrum mus. Blandit amet elementum sed elementum adipiscing velit neque massa vitae. Pharetra porta proin sollicitudin faucibus eget laoreet in.

                        Nunc nisl fringilla eget ipsum auctor. Cras nibh risus vivamus nulla et. Sit non suspendisse at dolor lacus. Ipsum nunc elit porttitor pellentesque nibh odio non. Consectetur elementum mi et massa faucibus. Mauris iaculis id odio sed id sit vitae tempus consectetur. Consectetur dui ut cursus morbi lacus. Posuere pharetra a turpis pellentesque aenean. Netus egestas blandit scelerisque tincidunt mollis sit varius sit.
                    </p>
                </div>
                <div class="organizer">
                    <div class="heading">Organized By:</div>
                    <div class="name">John Doe</div>
                </div>
            </div>
        </div>


    </div>
</div>


@endsection