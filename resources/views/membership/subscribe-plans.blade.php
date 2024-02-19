@extends('public.membership.layout')

@section('content')
    <form action="{{route('subscribe.membership')}}" method="post" id="membership-form">
        <div class="container">
            <div class="row">
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
        @if($userPlans->monthlyMembershipPlan->count() > 0)
        <div class="container">
            <div class="row">
                <h1>Monthly Plan</h1>    
                @foreach($userPlans->monthlyMembershipPlan as $plan)
                <div class="container">
                    <div class="row">
                        <div class="col d-flex justify-content-start">
                            <input class="mx-2" type="radio" name="plan" value="{{$plan->id}}" required>
                            <p class="mx-2">{{$plan->name}}</p>
                            <p class="mx-2">${{$plan->amount}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @if($userPlans->annuallyMembershipPlan->count() > 0 )
        <div class="container">
            <div class="row">
                <h1>Annually Plan</h1>
                @foreach($userPlans->annuallyMembershipPlan as $plan)
                <div class="container">
                    <div class="row">
                        <div class="col d-flex justify-content-start">
                            <input class="mx-2" type="radio" name="plan" value="{{$plan->id}}" required>
                            <p class="mx-2" >{{$plan->name}}</p>
                            <p class="mx-2" >{{$plan->amount}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div id="card-element"></div>
                </div>
            </div>
        </div>

        <button type="submit" class="submit-btn">Add Subscription<i class="fas fa-circle-notch fa-spin mx-2 d-none loader"></i></button>
    
    </form>
    
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(document).ready(function(){
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
            let submitBtn = this.querySelector(".submit-btn");
            form.append('payment_method' , setupIntent.payment_method);
            addFormData(url , form , loader , null , submitBtn , null)

        }

        

        

    })















    })
</script>

@endsection