@extends('public.membership.layout')
<style>
    #membership-form{
        margin-top: 50px;
    }
    .form-group{
        margin-bottom: 15px;
    }
    label{
        font-family: Poppins;
        margin-bottom: 5px;
    }
    input{
        height: 50px;
    }
    .donate-noe-layout .rectangle{
        height: 200px !important;
    }
    .plan-title{
        font-size: 25px;
        font-family: Poppins;
        position: absolute;
        top: -16px;
        background: #fff;
        padding-left: 10px;
        padding-right: 10px;
    }
    .pay-strip-sec{
        margin-top: 30px;
    }
    .pay-strip-sec p{
        margin-bottom: 0;
        font-family: Poppins;
    }
    .radio-action{
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    .CardField-input-wrapper{
        height: 55px !important;
    }
    iframe{
        height: 55px !important; 
    }
    .pay-strip-sec{
        border: 1px solid #eee;
        padding: 30px 15px 15px 15px;
        border-radius: 7px;
        margin-bottom: 16px;
        position: relative;
    }
</style>
@section('content')
    <form action="{{route('subscribe.membership')}}" method="post" id="membership-form">
        <div class="container px-0 input-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                        <small  class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control" id="first_name"  placeholder="Enter First Name">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" id="last_name"  placeholder="Enter Last Name">
                    </div>
                </div>
            </div>
        </div>
        <button type="button" class="btn-next btn btn-success">Next</button>
        <div class="pay-data">
            @if($userPlans->monthlyMembershipPlan->count() > 0)
            <div class="container px-0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="pay-strip-sec">
                            <h1 class="plan-title">Monthly Plan</h1>    
                            @foreach($userPlans->monthlyMembershipPlan as $plan)
                                    <div class="radio-action">
                                        <input class="h-auto" type="radio" name="plan" value="{{$plan->id}}" required>
                                        <p class="mx-2">{{$plan->name}}</p>
                                        <p class="mx-2">${{$plan->amount}}</p>
                                    </div>
                            
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if($userPlans->annuallyMembershipPlan->count() > 0 )
            <div class="container px-0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="pay-strip-sec">
                            <h1>Annually Plan</h1>
                            @foreach($userPlans->annuallyMembershipPlan as $plan)
                                <div class="radio-action">
                                    <input class="h-auto" type="radio" name="plan" value="{{$plan->id}}" required>
                                    <p class="mx-2" >{{$plan->name}}</p>
                                    <p class="mx-2" >{{$plan->amount}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="container px-0">
                <div class="row">
                    <div class="col-6">
                        <div id="card-element"></div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-back btn btn-default">Back</button>
            <button type="submit" class="submit-btn btn btn-success">Add Subscription<i class="fas fa-circle-notch fa-spin mx-2 d-none loader"></i></button>
        </div>
    
    </form>
    
@endsection

@section('script')
@include('common-script')
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(".pay-data").hide();
    $(document).ready(function(){
        $(".btn-next").click(function(){
            $(".input-data").hide();
            $(".pay-data").show();
            $(".btn-next").hide();
        });
        $(".btn-back").click(function(){
            $(".input-data").show();
            $(".pay-data").hide();
            $(".btn-next").show();
        });
        var stripe = Stripe('{{env("STRIPE_KEY")}}' , { 'stripeAccount' : '{{$connectedId}}'})
        
        var card = null;
    
        createCardElements()
    
        function createCardElements(){
            const element = stripe.elements();
            card = element.create('card')
            card.mount("#card-element");
        }


        document.querySelector("#membership-form").addEventListener("submit" , async function(e){
        e.preventDefault();
        let form = new FormData(this);
        let loader = this.querySelector(".loader")

        loader.classList.remove("d-none");

        let clientSecret = await getSetupIntent("{{$connectedId}}").then(data =>{
            return data;
        })

        const { setupIntent, error} = await stripe.confirmCardSetup( clientSecret , {
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
            let submitBtn = this.querySelector(".submit-btn");
            let redirectUrl = '{{url("success-membership")}}';
            form.append('payment_method' , setupIntent.payment_method);

            addFormData(url , form , loader , redirectUrl , submitBtn , null)

        }

        

        

    })















    })
</script>

@endsection