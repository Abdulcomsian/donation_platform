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
<link rel="stylesheet" href="{{ asset('assets/css/membership.css') }}">
@endsection

@section('content')
<div class="membership">
    <div class="header">
        <div class="heading">
            Membership  @if($monthlyPlans->count() || $annuallyPlans->count())  <a href="{{url('membership-list' , Crypt::encrypt(auth()->user()->id) )}}" class="link-btn">Link<i class="fa-solid fa-arrow-up-right-from-square mx-2"></i></a> @endif
        </div>
        <div class="description">
            <div class="row">
                <div class="col-md-5">
                    Lorem ipsum dolor sit amet consectetur. Nulla vulputate nunc facilisis pretium. Commodo amet quisque
                    tellus porttitor enim augue ultrices. Malesuada nisl commodo enim tempus pharetra nulla erat.
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form action="">
            <div class="row">
                <div class="col-md-10">
                    <div class="monthly-membership">
                        <div class="heading">
                            Monthly Memberships
                        </div>
                        
                        <div class="form-container" id="monthly">
                            @foreach($monthlyPlans as $plan)
                            <div class="tier monthly-tier wrapper-element monthly-saved-tier">
                                <input type="hidden" name="plan_id" value="{{$plan->id}}" readonly>
                                <div class="name">
                                    <input type="text" id="name" name="name" placeholder="Tier Name" value="{{$plan->name}}" readonly>
                                </div>

                                <div class="currency-input">
                                    <span>$</span>
                                    <input type="number" step="0.01" inputmode="decimal" name="amount" value="{{$plan->amount}}" min="0" readonly placeholder="0">
                                </div>

                                <div class="remove">
                                    <button type="button" onclick="removeMontlyTier(event , 1)" data-plan-id="{{$plan->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13.0436 11.5919L17.3112 15.8595C17.5137 16.0616 17.6277 16.336 17.6279 16.6222C17.6282 16.9084 17.5147 17.1829 17.3125 17.3855C17.1104 17.588 16.836 17.7019 16.5498 17.7022C16.2636 17.7024 15.9891 17.589 15.7865 17.3868L11.519 13.1192L7.25138 17.3868C7.04884 17.5893 6.77414 17.7031 6.48771 17.7031C6.20128 17.7031 5.92658 17.5893 5.72404 17.3868C5.5215 17.1843 5.40771 16.9096 5.40771 16.6231C5.40771 16.3367 5.5215 16.062 5.72404 15.8595L9.99162 11.5919L5.72404 7.3243C5.5215 7.12176 5.40771 6.84706 5.40771 6.56063C5.40771 6.2742 5.5215 5.9995 5.72404 5.79696C5.92658 5.59442 6.20128 5.48064 6.48771 5.48064C6.77414 5.48064 7.04884 5.59442 7.25138 5.79696L11.519 10.0645L15.7865 5.79696C15.9891 5.59442 16.2638 5.48064 16.5502 5.48064C16.8366 5.48064 17.1113 5.59442 17.3139 5.79696C17.5164 5.9995 17.6302 6.2742 17.6302 6.56063C17.6302 6.84706 17.5164 7.12176 17.3139 7.3243L13.0436 11.5919Z"
                                                fill="#949494" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach

                            @if($monthlyPlans->count() < 3)
                            <div class="tier monthly-tier wrapper-element">
                                
                                <div class="name">
                                    <input type="text" id="name" name="name" placeholder="Tier Name">
                                </div>

                                <div class="currency-input">
                                    <span>$</span>
                                    <input type="number" step="0.01" inputmode="decimal" name="amount" min="0"
                                        placeholder="0">
                                </div>

                                <div class="remove">
                                    <button type="button" onclick="removeMontlyTier(event)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13.0436 11.5919L17.3112 15.8595C17.5137 16.0616 17.6277 16.336 17.6279 16.6222C17.6282 16.9084 17.5147 17.1829 17.3125 17.3855C17.1104 17.588 16.836 17.7019 16.5498 17.7022C16.2636 17.7024 15.9891 17.589 15.7865 17.3868L11.519 13.1192L7.25138 17.3868C7.04884 17.5893 6.77414 17.7031 6.48771 17.7031C6.20128 17.7031 5.92658 17.5893 5.72404 17.3868C5.5215 17.1843 5.40771 16.9096 5.40771 16.6231C5.40771 16.3367 5.5215 16.062 5.72404 15.8595L9.99162 11.5919L5.72404 7.3243C5.5215 7.12176 5.40771 6.84706 5.40771 6.56063C5.40771 6.2742 5.5215 5.9995 5.72404 5.79696C5.92658 5.59442 6.20128 5.48064 6.48771 5.48064C6.77414 5.48064 7.04884 5.59442 7.25138 5.79696L11.519 10.0645L15.7865 5.79696C15.9891 5.59442 16.2638 5.48064 16.5502 5.48064C16.8366 5.48064 17.1113 5.59442 17.3139 5.79696C17.5164 5.9995 17.6302 6.2742 17.6302 6.56063C17.6302 6.84706 17.5164 7.12176 17.3139 7.3243L13.0436 11.5919Z"
                                                fill="#949494" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="add-new">
                            <button type="button" onclick="addNewMonthlyTier(event)"><span>+</span>Add Tier</button>
                        </div>

                        <div class="submit-container">
                            {{-- <div class="create">
                                <button type="submit">Create Membership Campaign</button>
                            </div> --}}
                            <div class="save">
                                <button type="button" class="monthly-save-btn">Save <i class="fas fa-circle-notch fa-spin mx-2 d-none loader"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="annual-membership">
                        <div class="heading">
                            Annual Memberships
                        </div>

                        <div class="form-container" id="annualy">

                            @foreach($annuallyPlans as $plan)
                            <div class="tier annually-tier wrapper-element annually-saved-tier">
                                <input type="hidden" name="plan_id" value="{{$plan->id}}" readonly>
                                <div class="name">
                                    <input type="text" id="name" name="name" placeholder="Tier Name" value="{{$plan->name}}" readonly>
                                </div>

                                <div class="currency-input">
                                    <span>$</span>
                                    <input type="number" step="0.01" inputmode="decimal" name="amount" min="0" placeholder="0" value="{{$plan->amount}}" readonly>
                                </div>

                                <div class="remove">
                                    <button type="button" onclick="removeAnnualyTier(event , 1)"  data-plan-id="{{$plan->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13.0436 11.5919L17.3112 15.8595C17.5137 16.0616 17.6277 16.336 17.6279 16.6222C17.6282 16.9084 17.5147 17.1829 17.3125 17.3855C17.1104 17.588 16.836 17.7019 16.5498 17.7022C16.2636 17.7024 15.9891 17.589 15.7865 17.3868L11.519 13.1192L7.25138 17.3868C7.04884 17.5893 6.77414 17.7031 6.48771 17.7031C6.20128 17.7031 5.92658 17.5893 5.72404 17.3868C5.5215 17.1843 5.40771 16.9096 5.40771 16.6231C5.40771 16.3367 5.5215 16.062 5.72404 15.8595L9.99162 11.5919L5.72404 7.3243C5.5215 7.12176 5.40771 6.84706 5.40771 6.56063C5.40771 6.2742 5.5215 5.9995 5.72404 5.79696C5.92658 5.59442 6.20128 5.48064 6.48771 5.48064C6.77414 5.48064 7.04884 5.59442 7.25138 5.79696L11.519 10.0645L15.7865 5.79696C15.9891 5.59442 16.2638 5.48064 16.5502 5.48064C16.8366 5.48064 17.1113 5.59442 17.3139 5.79696C17.5164 5.9995 17.6302 6.2742 17.6302 6.56063C17.6302 6.84706 17.5164 7.12176 17.3139 7.3243L13.0436 11.5919Z"
                                                fill="#949494" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach

                            @if($annuallyPlans->count() < 3)
                            <div class="tier annually-tier wrapper-element">
                                <div class="name">
                                    <input type="text" id="name" name="name" placeholder="Tier Name">
                                </div>

                                <div class="currency-input">
                                    <span>$</span>
                                    <input type="number" step="0.01" inputmode="decimal" name="amount" min="0"
                                        placeholder="0">
                                </div>

                                <div class="remove"
                                    <button type="button" onclick="removeAnnualyTier(event)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13.0436 11.5919L17.3112 15.8595C17.5137 16.0616 17.6277 16.336 17.6279 16.6222C17.6282 16.9084 17.5147 17.1829 17.3125 17.3855C17.1104 17.588 16.836 17.7019 16.5498 17.7022C16.2636 17.7024 15.9891 17.589 15.7865 17.3868L11.519 13.1192L7.25138 17.3868C7.04884 17.5893 6.77414 17.7031 6.48771 17.7031C6.20128 17.7031 5.92658 17.5893 5.72404 17.3868C5.5215 17.1843 5.40771 16.9096 5.40771 16.6231C5.40771 16.3367 5.5215 16.062 5.72404 15.8595L9.99162 11.5919L5.72404 7.3243C5.5215 7.12176 5.40771 6.84706 5.40771 6.56063C5.40771 6.2742 5.5215 5.9995 5.72404 5.79696C5.92658 5.59442 6.20128 5.48064 6.48771 5.48064C6.77414 5.48064 7.04884 5.59442 7.25138 5.79696L11.519 10.0645L15.7865 5.79696C15.9891 5.59442 16.2638 5.48064 16.5502 5.48064C16.8366 5.48064 17.1113 5.59442 17.3139 5.79696C17.5164 5.9995 17.6302 6.2742 17.6302 6.56063C17.6302 6.84706 17.5164 7.12176 17.3139 7.3243L13.0436 11.5919Z"
                                                fill="#949494" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="add-new">
                            <button type="button" onclick="addNewAnnualTier(event)"><span>+</span>Add Tier</button>
                        </div>
                    </div>

                    <div class="submit-container">
                        {{-- <div class="create">
                            <button type="submit">Create Membership Campaign</button>
                        </div> --}}
                        <div class="save">
                            <button type="button" class="annually-save-button">Save<i class="fas fa-circle-notch fa-spin mx-2 d-none loader"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    

    function removeMontlyTier(event , saveTier = null) {
        event.preventDefault();
        saveTier ? removeSaveTier(event , 1) : removeTier(event);
    }

    function removeAnnualyTier(event , saveTier = null) {
        event.preventDefault();
        saveTier ? removeSaveTier(event , 2) : removeTier(event);
    }


    function removeTier(event)
    {
        event.target.closest('.wrapper-element').remove();
    }

    function removeSaveTier(event , type)
    {
        let element = event.target.classList.contains("button") ? event.target : event.target.closest("button");
        let planId = element.dataset.planId;
        let url = "{{route('delete.membership')}}";
        let data = {planId : planId , type : type};
        console.log(planId);
        console.log(data);
        let confirmationHeader = "Are you sure you want to delete this plan";
        let confirmationTextBtn = "Delete";
        let confirmationText = "By deleting this plan all the data for this plan has been lost."
        confirmationUpdate(data , url , [ confirmationHeader , confirmationTextBtn , confirmationText] , null , ()=>removeTier(event));
    }

    function addNewMonthlyTier(event) {
        event.preventDefault();

        let totalMonthlyTier = document.querySelectorAll(".monthly-tier").length;

        if(totalMonthlyTier == 3){
            Swal.fire({
                        icon: "error",
                        title: 'Maximum 3 plans are allowed',
                    });
            return;
        }


        var newDiv = document.createElement('div');
        newDiv.className = 'tier monthly-tier wrapper-element';

        newDiv.innerHTML = `                                <div class="name">
                                    <input type="text" id="name" name="name" placeholder="Tier Name">
                                </div>

                                <div class="currency-input">
                                    <span>$</span>
                                    <input type="number" step="0.01" inputmode="decimal" name="amount" min="0"
                                        placeholder="0">
                                </div>

                                <div class="remove">
                                    <button type="button" onclick="removeMontlyTier(event)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13.0436 11.5919L17.3112 15.8595C17.5137 16.0616 17.6277 16.336 17.6279 16.6222C17.6282 16.9084 17.5147 17.1829 17.3125 17.3855C17.1104 17.588 16.836 17.7019 16.5498 17.7022C16.2636 17.7024 15.9891 17.589 15.7865 17.3868L11.519 13.1192L7.25138 17.3868C7.04884 17.5893 6.77414 17.7031 6.48771 17.7031C6.20128 17.7031 5.92658 17.5893 5.72404 17.3868C5.5215 17.1843 5.40771 16.9096 5.40771 16.6231C5.40771 16.3367 5.5215 16.062 5.72404 15.8595L9.99162 11.5919L5.72404 7.3243C5.5215 7.12176 5.40771 6.84706 5.40771 6.56063C5.40771 6.2742 5.5215 5.9995 5.72404 5.79696C5.92658 5.59442 6.20128 5.48064 6.48771 5.48064C6.77414 5.48064 7.04884 5.59442 7.25138 5.79696L11.519 10.0645L15.7865 5.79696C15.9891 5.59442 16.2638 5.48064 16.5502 5.48064C16.8366 5.48064 17.1113 5.59442 17.3139 5.79696C17.5164 5.9995 17.6302 6.2742 17.6302 6.56063C17.6302 6.84706 17.5164 7.12176 17.3139 7.3243L13.0436 11.5919Z"
                                                fill="#949494" />
                                        </svg>
                                    </button>
                                </div>`,
        
        document.getElementById('monthly').appendChild(newDiv)
    }

    function addNewAnnualTier(event) {
        event.preventDefault();

        let totalAnnuallyTier = document.querySelectorAll(".annually-tier").length;

        if(totalAnnuallyTier == 3){
            Swal.fire({
                        icon: "error",
                        title: 'Maximum 3 plans are allowed',
                    });
            return;
        }

        var newDiv = document.createElement('div');
        newDiv.className = 'tier annually-tier wrapper-element';

        newDiv.innerHTML = `    <div class="name">
                                    <input type="text" id="name" name="name" placeholder="Tier Name">
                                </div>

                                <div class="currency-input">
                                    <span>$</span>
                                    <input type="number" step="0.01" inputmode="decimal" name="amount" min="0"
                                        placeholder="0">
                                </div>

                                <div class="remove" onclick="removeAnnualyTier(event)">
                                    <button type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13.0436 11.5919L17.3112 15.8595C17.5137 16.0616 17.6277 16.336 17.6279 16.6222C17.6282 16.9084 17.5147 17.1829 17.3125 17.3855C17.1104 17.588 16.836 17.7019 16.5498 17.7022C16.2636 17.7024 15.9891 17.589 15.7865 17.3868L11.519 13.1192L7.25138 17.3868C7.04884 17.5893 6.77414 17.7031 6.48771 17.7031C6.20128 17.7031 5.92658 17.5893 5.72404 17.3868C5.5215 17.1843 5.40771 16.9096 5.40771 16.6231C5.40771 16.3367 5.5215 16.062 5.72404 15.8595L9.99162 11.5919L5.72404 7.3243C5.5215 7.12176 5.40771 6.84706 5.40771 6.56063C5.40771 6.2742 5.5215 5.9995 5.72404 5.79696C5.92658 5.59442 6.20128 5.48064 6.48771 5.48064C6.77414 5.48064 7.04884 5.59442 7.25138 5.79696L11.519 10.0645L15.7865 5.79696C15.9891 5.59442 16.2638 5.48064 16.5502 5.48064C16.8366 5.48064 17.1113 5.59442 17.3139 5.79696C17.5164 5.9995 17.6302 6.2742 17.6302 6.56063C17.6302 6.84706 17.5164 7.12176 17.3139 7.3243L13.0436 11.5919Z"
                                                fill="#949494" />
                                        </svg>
                                    </button>
                                </div>`,
        
        document.getElementById('annualy').appendChild(newDiv)
    }

    document.querySelectorAll(".monthly-save-btn , .annually-save-button").forEach( button => {
        
        button.addEventListener("click" , function(event){
            event.preventDefault();
            let tier = this.classList.contains("monthly-save-btn") ?  document.querySelectorAll(".monthly-tier:not(.monthly-saved-tier)") : document.querySelectorAll(".annually-tier:not(.annually-saved-tier)");
            let loader = this.querySelector(".loader");

            if(tier.length == 0){
                Swal.fire({
                            icon: "error",
                            title: 'Maximum add atleast one plan',
                        });
                return;
            }

            let check = [null , undefined , ''];
            let type = this.classList.contains("monthly-save-btn") ? 1 : 2;
            let error = [];
            let plans = [];
            tier.forEach(tier =>{
                let name = tier.querySelector('input[name="name"]').value;
                let amount = tier.querySelector('input[name="amount"]').value;
                if(check.includes(name.trim())){
                    error.push("Please add name");
                }

                if(check.includes(amount.trim()) || parseFloat(amount) <= 0 ){
                    error.push("Amount must be required and greater the 0 ");
                }

                if(error.length > 0){
                    return;
                }else{
                    plans.push({name : name , amount : amount , type : type});   
                }

            });

            if(error.length > 0){
                let errorMsg = error.join(", ");
                Swal.fire({
                            icon: "error",
                            text: errorMsg,
                        });
                return;
            }


            let url = "{{route('create.membership')}}";
            let data = { plans : plans, type : type };
            updateData(data , url , loader , null , reloadPage)

        })
        
    });

    function reloadPage()
    {
        location.reload();
    }

    
</script>
@endsection