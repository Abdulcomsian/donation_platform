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
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Ticket</button>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="detail-modal">
            
            <form action="#" class="form-steps" autocomplete="off">
                <div class="event-det mb-3">
                    <h3>{{$event->title}}</h3>
                    {{\Carbon\Carbon::parse($event->date)->format('l j F, Y')}}, {{\Carbon\Carbon::parse($event->time)->format('g:i A')}}
                </div>
                <div class="w-75 mx-auto">
                        <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                            <li class="nav-item" role="presentation" data-progressbar="custom-progress-bar" id="pills-gen-info-tab" data-bs-toggle="pill" data-bs-target="#pills-gen-info" type="button" role="tab" aria-controls="pills-gen-info" aria-selected="true" data-position="0">
                                <button class="nav-link rounded-pill active">1</button>
                                <span>Select Tickets</span>
                            </li>
                            <li class="nav-item" role="presentation" data-progressbar="custom-progress-bar" id="pills-info-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-info-desc" type="button" role="tab" aria-controls="pills-info-desc" aria-selected="false" data-position="1" tabindex="-1">
                                <button class="nav-link rounded-pill">2 </button>
                                <span>Your Details</span>
                            </li>
                            <li class="nav-item" role="presentation" data-progressbar="custom-progress-bar" id="pills-success-tab" data-bs-toggle="pill" data-bs-target="#pills-success" type="button" role="tab" aria-controls="pills-success" aria-selected="false" data-position="2" tabindex="-1">
                                <button class="nav-link rounded-pill">3 </button>
                                <span>Payment</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pills-gen-info" role="tabpanel" aria-labelledby="pills-gen-info-tab">
                        <div class="tab-data">
                          
                            @foreach($event->ticket as $ticket)
                                @if($ticket->users->count() == 0 || ($ticket->users->count() > $ticket->quantity))
                                <div class="ticket-box">
                                    <div class="ticket-detail">
                                        <h3>
                                           {{$ticket->name}}
                                        </h3>
                                        <p>
                                            {{$ticket->description}}
                                        </p>
                                        @if($ticket->is_free)
                                        <span>
                                            Free
                                        </span>
                                        @else
                                        <span>
                                            ${{number_format($ticket->price)}}
                                        </span>
                                        @endif
                                    </div>
                                    <div class="ticket-count">
                                        <input type="number" data-ticket-id="{{$ticket->id}}" data-ticket-amount="{{$ticket->amount}}" min="1" max="{{$ticket->quantity - $ticket->users->count()}}" class="form-control" id="basiInput">
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <span class="sub-total">Sub Total:  <b>$0</b></span>
                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-info-desc-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                        </div>
                    </div>
                    <!-- end tab pane -->

                    <div class="tab-pane fade" id="pills-info-desc" role="tabpanel" aria-labelledby="pills-info-desc-tab">
                        <div>
                            <div class="order-summary">
                                <h3>
                                    Order Summary
                                </h3>
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap mb-0 px-20">
                                        <tbody>
                                            <tr>
                                                <td>Ticket Name</td>
                                                <td>Qty:  1</td>
                                                <td class="text-end">$20</td>
                                            </tr>
                                            <tr>
                                                <td>Ticket Name</td>
                                                <td>Qty:  1</td>
                                                <td class="text-end">$20</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end"><b>Sub Total:  $75</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h3 class="mt-5">
                                    Provide Your Details
                                </h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Name</label>
                                            <input type="password" class="form-control" id="basiInput">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Email</label>
                                            <input type="password" class="form-control" id="basiInput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline float-end action-bttn gap-3 mt-4">
                            <button type="button" class="btn btn-default text-decoration-none btn-label previestab" data-previous="pills-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back</button>
                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-success-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                        </div>
                    </div>
                    <!-- end tab pane -->

                    <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">
                        <div>
                            <div class="order-summary">
                                <h3>
                                    Order Summary
                                </h3>
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap mb-0 px-20">
                                        <tbody>
                                            <tr>
                                                <td>Ticket Name</td>
                                                <td>Qty:  1</td>
                                                <td class="text-end">$20</td>
                                            </tr>
                                            <tr>
                                                <td>Ticket Name</td>
                                                <td>Qty:  1</td>
                                                <td class="text-end">$20</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td class="text-end"><b>Sub Total:  $75</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h3 class="mt-5">
                                    Debit/Credit Card
                                </h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <label for="basiInput" class="form-label">Card Number</label>
                                            <input type="text" class="form-control" id="basiInput" placeholder="1234 1234 1234 1234">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">Expiry Date</label>
                                            <input type="text" class="form-control" id="basiInput" placeholder="MM / YY">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <label for="basiInput" class="form-label">CVC</label>
                                            <input type="text" class="form-control" id="basiInput" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label for="basiInput" class="form-label">Country</label>
                                            <select class="form-select" aria-label="Default select example" style="width: 80px;">
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline float-end action-bttn gap-3 mt-4">
                            <button type="button" class="btn btn-default text-decoration-none btn-label previestab" data-previous="pills-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back</button>
                            <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-success-tab"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit</button>
                        </div>
                    </div>
                    <!-- end tab pane -->
                </div>
                <!-- end tab content -->
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    $(".progress-bar-tab.custom-nav li").click(function(){
        $(".progress-bar-tab.custom-nav li").removeClass("active");
    });
</script>
@endsection