@extends('public.donate.layout')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('assets/css/donate-now-card.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endsection

@section('content')
<div class="donate-now-card">
    <div class="card">
        <div class="card-top">
            <div class="heading">
                <span class="back-btn toggle-donation d-none"><i class="fa-solid fa-arrow-left"></i></span> Donate Now 
            </div>

            <div class="form-container">
                <form id="donation-form" action="{{route('add.donation')}}" method="POST">
                    <div class="donation-selection-area donation-form">
                        <input type="hidden" name="campaign_id" value="{{$campaign->id}}">
                        <div class="campaign-item">
                            <label for="campaign">Campaign</label>
                            <input type="text" readonly value="{{$campaign->title}}" id="campaign" name="campaign">
                        </div>
                        
                        <div class="amount-item">
                            <label for="amount">Select or Enter Amount</label>
                            <div class="row static-amount">
                                @foreach($userPlans as $plan)
                                <div class="col-md-3 donation-amount-box">
                                    <div class="item donation-amount" data-donation-amount="{{$plan->amount}}" data-plan-id="{{$plan->id}}">{{$plan->amount}}</div>
                                </div>
                                @endforeach
                            </div>
                            <div class="currency-input">
                                <span>$</span>
                                <input type="number" id="amount" step="0.01" inputmode="decimal" min="0.25"
                                    placeholder="0">
                            </div>
                        </div>
    
                        <div class="frequency-item">
                            <label for="frequency">Frequency</label>
                            <div class="row frequency-types">
                                <div class="col-md-6">
                                    <div class="type active" id="oneTime" onclick="changeActive('oneTime', 'recurring')">
                                        <div class="text">One Time</div>
                                        <div class="icon">
                                            <img src="{{ asset('assets/images/Vector.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                @if($userPlans->count() > 0)
                                <div class="col-md-6">
                                    <div class="type" id="recurring" onclick="changeActive('recurring', 'oneTime')">
                                        <div class="text">Recurring</div>
                                        <div class="icon">
                                            <img src="{{ asset('assets/images/Vector.png') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
    
                        @if($userPlans->count() > 0)
                        <div class="container-fluid recurring-box d-none">
                            <div class="row">
                                    <div class="col-12 p-0 mt-4">
                                        <select name="frequency" class="form-select frequency-select">
                                            <option value="" selected disabled>Select Frequency</option>
                                                @foreach($campaign->frequencies as $frequency)
                                                    <option value="{{$frequency->type}}">{{ucfirst($frequency->type)}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                            </div>
                        </div>
                        @endif
    
                        <div class="donate-btn">
                            <button class="toggle-donation" type="button">Continue</button>
                        </div>
                        @if($campaign->campaign_goal)
                        <div class="progress-container">
                            @php
                                $percentage = 1;
                                $donationAmount = 0;
                                if($campaign->donations->count()){
                                    foreach($campaign->donations as $donation){
                                        // $percentage = ($campaign->donations->sum('amount') / $campaign->amount) * 100;
                                        $donationAmount += isset($donation->plan) ? $donation->plan->amount : $donation->amount;
                                    }
                                    $percentage = ($donationAmount / $campaign->amount) * 100;
                                } 
                           @endphp
    
                            <div class="progress-bar-element">
                                <progress value="{{$percentage}}" max="100"></progress>
                            </div>
                            <div class="text">${{ceil($donationAmount)}}/{{ceil($campaign->amount)}}</div>
                        </div>
                        @endif
                    </div>
                    <div class="donation-detail-area donation-form d-none my-3">
                        <div class="container">
                            <div class="row">
                                <div class="col-6 my-2">
                                    <div>
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="theme-input-text form-css" id="first_name" name="first_name">
                                    </div>
                                </div>
                                <div class="col-6 my-2">
                                    <div>
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="theme-input-text form-css" id="last_name" name="last_name">
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="form-group">
                                        <div>
                                            <label for="email">Email</label>
                                        </div>
                                        <input type="text" class="theme-input-text w-100 form-css" id="email" name="email">
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="form-group">
                                        <div>
                                            <label for="Phone">Phone</label>
                                        </div>
                                        <input type="text" class="theme-input-text w-100 form-css" id="phone" name="phone" >
                                    </div>
                                </div>
                                <div class="col-6 my-2">
                                    <div class="form-group">
                                        <div>
                                            <label for="country">Country</label>
                                        </div>
                                        <select name="country" id="country" class="form-select country-select" >
                                                <option selected disabled>Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->id}}">{{ucfirst($country->name)}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 my-2">
                                    <div class="form-group">
                                        <div>
                                            <label for="city">City</label>
                                        </div>
                                        <select name="city" id="city" class="form-select city-select" >
                                            <option value="" selected disabled>Select Country</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 my-2">
                                    <div class="form-group">
                                        <div>
                                            <label for="street">Street</label>
                                        </div>
                                        <input type="text" class="theme-input-text w-100 form-css" id="street" name="street">
                                    </div>
                                </div>
                                <div id="card-element"></div>
                                <div class="col-12">
                                    <div class="donate-btn">
                                        <button class="donate donate-btn" type="submit">Donate <i class="fas fa-circle-notch fa-spin mx-2 d-none submit-loader"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-bottom">
            <div class="text1">Powered By</div>
            <div class="text2">Lorem Ipsum</div>
        </div>
    </div>
</div>



@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>


function changeActive(item1, item2) {
        document.getElementById(item1).classList.add('active')
        document.getElementById(item2).classList.remove('active')
        let amount = document.getElementById("amount");
        if(item1 === 'recurring'){
            document.querySelector('.recurring-box').classList.remove('d-none');
            amount.setAttribute("readonly" , true);
        }else{
            document.querySelector('.recurring-box').classList.add('d-none');
            amount.removeAttribute("readonly");
        } 

    }

    $(document).ready(function(){
        var stripe = Stripe('{{env("STRIPE_KEY")}}' , { 'stripeAccount' : '{{$connectedId}}'})
        
        var card = null;

        createCardElements()

        function createCardElements(){
            const element = stripe.elements();
            card = element.create('card')
            card.mount("#card-element");
        }

    

    


    

    document.querySelectorAll(".donation-amount-box").forEach(box => {
        box.addEventListener("click" , function(){
            inactivePredefinedDonationBox();
            let donationAmountBox = this.classList.contains("donation-amount-box") ? this : this.closest("donation-amount-box");
            let donationAmount = this.classList.contains("donation-amount") ? this.dataset.donationAmount : this.querySelector(".donation-amount").dataset.donationAmount;
            donationAmountBox.classList.add('active');
            document.getElementById("amount").value = donationAmount;
        }); 
    })

    document.querySelector("#amount").addEventListener("keyup" , function(e){
        if(e.keyCode >= 48 && e.keyCode <= 57){
            inactivePredefinedDonationBox();
        }
    })
    

    function inactivePredefinedDonationBox(){
        document.querySelectorAll(".donation-amount-box").forEach(item => {
                item.classList.remove("active");
            })
    }


    document.querySelectorAll(".toggle-donation").forEach(btn=>{
        btn.addEventListener("click" , function(){
            let donationForms = document.querySelectorAll(".donation-form");
            let error = checkRecurringOption();
            if(error){
                Swal.fire({ icon: "error", title: "Oops...", text: error});
                return;
            }

            if(donationForms[0].classList.contains("d-none")){
                donationForms[0].classList.remove("d-none")
                donationForms[1].classList.add("d-none");
                document.querySelector(".back-btn").classList.add("d-none");

            }else{
                donationForms[1].classList.remove("d-none")
                donationForms[0].classList.add("d-none");
                document.querySelector(".back-btn").classList.remove("d-none");
            }
        })
    })


    function checkRecurringOption(){
        let errors = null;
        let amount = plan = null; 
        let recurring = document.getElementById("recurring");
        
        if(recurring && recurring.classList.contains("active")){
            let activePlan = document.querySelector(".donation-amount-box.active");
            let frequency = document.querySelector(".frequency-select");
            activePlan === null ? errors = "Please select plan for recursive transaction" : plan = activePlan.querySelector(".donation-amount").dataset.planId;
            frequency.value == "" && (errors = "Please select plan");
        }else{
            let chargeAmount = document.getElementById("amount");
            chargeAmount.value.trim() === null || chargeAmount.value.trim()  < 1  || chargeAmount.value.trim() == "" ? errors ="Amount should be greater or equal to $1" : amount = chargeAmount.value;
        }
        return errors !== null ? errors : false; 
    }


    document.querySelector("select[name='country']").addEventListener("change" , function(){
        let country = this.value;
        $.ajax({
            url : "{{route('get.country.cities')}}",
            type : "POST",
            data : {
                country: country,
                _token : "{{csrf_token()}}"
            },
            success: function(res){
                if(res.status){
                    document.querySelector(".city-select").innerHTML = res.cities;
                }
            }
        })
    })

    document.querySelector("#donation-form").addEventListener("submit" , async function(e){
        e.preventDefault();

        let form = new FormData(this);
        let firstName = document.getElementById("first_name").value;
        let lastName = document.getElementById("last_name").value;
        let email = document.getElementById("email").value;
        let country = document.getElementById("country").value;
        let city = document.getElementById("city").value;
        let amount = document.getElementById("amount").value;
        let loader = document.querySelector(".submit-loader");
        

        loader.classList.remove("d-none");

        let fields = {
                'First_name' : firstName,
                'Last_name' : lastName,
                'Email' : email,
                'Country' : country,
                'City' : city 
        }

        let errors = null;

        for(const field in fields ){
            if(validator.isEmpty(fields[field])){
                let key = field.replace(/_/g, ' ');
                errors === null ? errors = `${key} Must Be Required` : errors += `, ${key} Must Be Required`;
            }
        }


        if(errors !== null){
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errors+=".",
                });
                loader.classList.add("d-none");
                return;
        }

        const { setupIntent, error} = await stripe.confirmCardSetup( '{{$clientSecret}}' , {
                                                                        payment_method : {
                                                                            card : card,
                                                                        }
                                                                });


        if(error){
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: error.message,
            });
            loader.classList.remove("d-none");
            return;
        }else{

            
            let url = this.getAttribute('action');
            let submitBtn = this.querySelector(".donate.donate-btn");
            form.append('amount' , amount);
            form.append('plan_id' , plan);
            form.append('payment_method' , setupIntent.payment_method);
            addFormData(url , form , loader , null , submitBtn , null)

        }

        

        

    })


    function checkRequired(field){
       return validator.isEmpty(field)
    }


    
})

</script>
@include('common-script')
@endsection