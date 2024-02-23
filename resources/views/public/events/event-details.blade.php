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
                <div class="tab-pane fade show active" id="tab11" role="tabpanel" aria-labelledby="pills-gen-info-tab">
                        <div class="tab-data">
                          @php
                           $tot_ticket = 0;
                          @endphp
                        @foreach($event->ticket as $index => $ticket)
                            @php
                                $purchasedTickets = 0;

                                if($ticket->users->count()){
                                    foreach($ticket->users as $user){
                                        $purchasedTickets += $user->pivot->quantity;
                                    }
                                }
                               
                            @endphp
                            @if( $ticket->quantity > $purchasedTickets)
                                @php
                                    $tot_ticket = $tot_ticket + 1;
                                @endphp
                                <div class="ticket-box">
                                    <div class="ticket-detail">
                                        <h3 id="ticketname-{{$index}}">
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
                                        <input type="hidden" value="{{number_format($ticket->price)}}" id="ticket_price-{{$tot_ticket-1}}" />
                                    </div>
                                    <div class="ticket-count">
                                    <input type="number" value="0" data-ticket-id="{{$ticket->id}}" data-ticket-amount="{{$ticket->price}}" min="1" max="{{$ticket->quantity - $ticket->users->count()}}" class="form-control ticket-quantity" id="basiInput-{{$tot_ticket-1}}" onchange="calc_price()">
                                </div>
                                </div>
                            @endif
                        @endforeach
                            
                            <input type="hidden" value="{{$event->ticket}}" id="array_name" />
                            <input type="hidden" value="{{$tot_ticket}}" id="tot_iteration" />
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-4">
                            <span class="sub-total">Sub Total: <b id="sub_total">$0</b></span>
                            <button type="button" class="btn btn-success btn-label right ms-auto first-next"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                        </div>
                    </div>
                    <!-- end tab pane -->

                    <div class="tab-pane fade" id="tab22" role="tabpanel" aria-labelledby="pills-info-desc-tab">
                        <div>
                            <div class="order-summary">
                                <h3>
                                    Order Summary
                                </h3>
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap mb-0 px-20">
                                        <tbody class="tableBody">
                                            {{-- <tr>
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
                                                <td class="text-end"><b>Sub Total: $<span id="table_sub_total">75</span></b></td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                                <h3 class="mt-5">
                                    Provide Your Details
                                </h3>
                                <div class="row">
                                    <input type="hidden" name="event_id" id="event_id" value="{{$event->id}}">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="basiInput" class="form-label">First Name</label>
                                            <input type="text" required name="first_name" class="form-control required-field" id="first_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="basiInput" class="form-label">Last Name</label>
                                            <input type="text" name="last_name" class="form-control required-field" id="last_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="basiInput" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control required-field" id="email">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <label for="basiInput" class="form-label">Country</label>
                                            <select class="form-select" name="country" id="country" aria-label="Default select example">
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
                            <button type="button" class="btn btn-default text-decoration-none btn-label second-previous" data-previous="pills-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back</button>
                            <div class="d-inline float-end action-bttn gap-3">
                                <button type="button"  class="btn btn-success btn-label right ms-auto second-next"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2 "></i>Next</button>
                            </div>
                        </div>
                    </div>
                    <!-- end tab pane -->

                    <div class="tab-pane fade" id="tab33" role="tabpanel" aria-labelledby="pills-success-tab">
                        <div>
                            <div class="order-summary">
                                <h3>
                                    Order Summary
                                </h3>
                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap mb-0 px-20">
                                        <tbody class="tableBody">
                                            {{-- <tr>
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
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                                <h3 class="mt-5">
                                    Debit/Credit Card
                                </h3>
                                <div class="row">
                                    <div id="card-element"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-inline float-end action-bttn gap-3 mt-4">
                            <button type="button" class="btn btn-default text-decoration-none btn-label  third-previous" data-previous="pills-gen-info-tab"><i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Back</button>
                            <button type="button" class="btn btn-success btn-label right ms-auto third-next submit-form" data-nexttab="pills-success-tab">Submit<i class="fas fa-circle-notch fa-spin mx-2 d-none submit-loader"></i></button>
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
    $(".second-previous").click(function() {
        $("#tab22").removeClass("active show");
        $("#tab11").addClass("active show");
    });
    $(".second-next").click(function(e) {
        e.preventDefault();
        const err = [];
        const requiredFields = document.querySelectorAll('.required-field');
        requiredFields.forEach(element => {
            element.classList.remove('is-invalid')
            if(element.value === ''){
                const errorObj = {};
                errorObj[element.getAttribute('name')] = `${element.getAttribute('name')} is Required`
                err.push(errorObj)
                return
            }
            if(element.type == 'email'){
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test(element.value)){
                    const errorObj = {};
                    errorObj[element.getAttribute('name')] = `${element.getAttribute('name')} is Required`
                    err.push(errorObj)
                    return
                }
            }
          
        })
        if(err.length === 0){
                // document.querySelector('.founder-form').submit()
                $("#tab22").removeClass("active show");
                $("#tab33").addClass("active show");
            }else{
                displayErrors(err)

            }
      
            // $("#tab22").removeClass("active show");
            // $("#tab33").addClass("active show");
      
        
    });
    $(".third-previous").click(function() {
        $("#tab33").removeClass("active show");
        $("#tab22").addClass("active show");
    });
    $(".first-next").click(function() {
        $("#tab11").removeClass("active show");
        $("#tab22").addClass("active show");
    });
    $(".progress-bar-tab.custom-nav li").click(function() {
        $(".progress-bar-tab.custom-nav li").removeClass("active");
    });


    document.querySelectorAll(".ticket-quantity").forEach(field => {
        field.addEventListener("keyup" , function(e){
            let element = e.target;
            let maxQuantity = element.getAttribute('max');
            let value = element.value;
            if(value > maxQuantity){
                element.value = maxQuantity;
            }
        })
    })

    function calc_price() {
        tot_iteration = $('input[id^="tot_iteration"]').val();
        var totalval = parseFloat(0);
        var arr = $("#array_name").val();
        var jsonArray = JSON.parse(arr);
        $(".tableBody tr").remove();
        for (i = 0; i < tot_iteration; i++) {
            var qty =$(`input[id^=basiInput` + '-' + i).val();
            var int_val = $(`input[id^=ticket_price` + '-' + i).val();
            var ticket_name = $(`ticketname-{{$index}}` + '-' + i).text();
            var hidden = parseInt(qty);
           
            if ($(`input[id^=basiInput` + '-' + i).val() === "" || hidden<=0) {
                $(`input[id^=basiInput` + '-' + i).val(0);
                continue;
            }
            if(parseInt(hidden) > $(`input[id^=basiInput` + '-' + i).attr('max')){
                $(`input[id^=basiInput` + '-' + i).val($(`input[id^=basiInput` + '-' + i).attr('max'));
            }
            totalval = parseFloat(totalval) + (parseFloat(hidden) * parseFloat(int_val));
            // console.log(hidden, int_val, totalval, i);
            $(".tableBody").append(`<tr><td>${jsonArray[i]?.name}</td><td>Qty: ${hidden}</td><td class="text-end">$${hidden * int_val}</td></tr>`);
        }
        $(".tableBody").append(` <tr><td></td>
                                                <td></td>
                                                <td class="text-end"><b>Sub Total: $<span id="table_sub_total">${totalval}</span></b></td>
                                            </tr>`);
        $("#sub_total").text(totalval);
        $("#table_sub_total").text(totalval);
    }
</script>

<script>
    $(".progress-bar-tab.custom-nav li").click(function(){
        $(".progress-bar-tab.custom-nav li").removeClass("active");
    });

    $(document).ready(function(){
        var stripe = Stripe('{{env("STRIPE_KEY")}}')
        var card = null;

        createCardElements()

        function createCardElements(){
            const element = stripe.elements();
            card = element.create('card')
            card.mount("#card-element");
        }

        document.querySelector(".submit-form").addEventListener("click" , async function(e){
            e.preventDefault();
            tot_iteration = $('input[id^="tot_iteration"]').val();
            var totalval = parseFloat(0);
            var arr = $("#array_name").val();
            var jsonArray = JSON.parse(arr);
            let loader = this.classList.contains("submit-loader") ? this : this.querySelector(".submit-loader");
            loader.classList.remove("d-none")
            const array = [];
                // ticket = tickets : [
            for (i = 0; i < tot_iteration; i++) {
                let ticket_quantity = $(`input[id^=basiInput` + '-' + i).val();
                let ticket_id = $(`input[id^=basiInput` + '-' + i).attr("data-ticket-id");
                
         
                if(ticket_quantity > 0){
                    array.push({
                        id : ticket_id,
                        quantity : ticket_quantity,
                    });

                }
            
            }


            if(array.length == 0){
                Swal.fire({ 
                            icon: "error", 
                            title: "Oops...", 
                            text: "Please Add Atleast One Ticket"
                        });
                return;
            }
            
            const data = {
                email:$("#email").val(), 
                first_name :$("#first_name").val(), 
                last_name :$("#last_name").val(),
                country : $("#country").val(),
                event_id : $("#event_id").val(),
                subtotal:$("#table_sub_total").html(),
                tickets : array,
                _token : "{{csrf_token()}}"
            }

            const { setupIntent, error} = await stripe.confirmCardSetup( '{{$clientSecret}}' , {
                                                                        payment_method : {
                                                                            card : card,
                                                                        }
                                                                });
            if(setupIntent){

                let url = "{{route('purchase.ticket')}}";
                
                $.ajax({
                    type : "POST",
                    url : url,
                    data : {
                        paymentMethod: setupIntent.payment_method,
                        ...data
                    },
                    success:function(res){
                        loader.classList.add("d-none")
                        if(res.status){
                            Swal.fire({
                                text: res.msg,
                                icon: "success"
                            });

                            window.location.href= "{{url('payment-successfull')}}"

                        }else{
                            Swal.fire({ 
                                icon: "error", 
                                title: "Oops...", 
                                text: res.error
                            });
                        }
                    }
                })
            }else{
                            Swal.fire({ 
                                        icon: "error", 
                                        title: "Oops...", 
                                        text: error.message
                                    });
            }
        })
    })


   
    function displayErrors(errors){
        const ErrorKeys = [];
        for(let [index, key] of errors.entries()){
            const [inputNameProp, inputNameValue] = Object.entries(key);
            const erroredInput = document.querySelector(`input[name="${inputNameProp[0]}"]`);erroredInput.classList.add('is-invalid')
            erroredInput.setAttribute('required', true)
            if(index === 0) erroredInput.focus();
        }
    }
</script>
@endsection