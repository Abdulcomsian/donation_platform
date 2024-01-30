@extends('layouts.app')

@section('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/register-main.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<script src="{{asset('assets/js/iconify.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<style>
    select {
        height: 52px;
        border-radius: 10px;
        padding: 0px 10px;
        color: #7b7777;
        border: 1px solid #7b7777;
    }

    .organization-container{
        height: 380px;
        overflow-y: scroll;
    }

    .organization-container::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color: #F5F5F5;
    }

    .organization-container::-webkit-scrollbar
    {
        width: 6px;
        background-color: #F5F5F5;
    }

    .organization-container::-webkit-scrollbar-thumb
    {
        background-color: #5BC17F;
    }

    .iti.iti--allow-dropdown {
        width: 97%;
        padding: 0px 5px;
        margin-left: 8px;
        border-radius: 14px;
    }

    .iti__selected-flag {
        border-right: 1px solid #cfcccc;
    }

    input#phone {
    width: 100%!important;
    height: 57px;
    border: 1px solid #cfcccc;
}

    @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .rotate-icon {
            animation: rotate 2s linear infinite; /* Adjust the duration and timing function as needed */
        }
</style>
@endsection

@section('content')
<div class="register">
    <div class="section-left">
        <div class="section-1">
            <div class="dash active"></div>
            <div class="dash"></div>
        </div>
        <input type="hidden" name="type" value="1">
        <div class="register" id="type-select-section">
            <div class="section-left">
                <div class="section-2">
                    <div class="type-selection">
                        <div class="text">How are you planning to raise funds?</div>
                        <div class="form-container">
                            <div class="form-item-1 active" onclick="eventHandler('form-item-2', 'form-item-1')">
                                <div class="left">
                                    <div class="icon"></div>
                                </div>
                                <div class="right">
                                    <div class="item">
                                        <div class="heading-1">
                                            <div class="label">Non Profit Organization</div>
                                            <div class="select-none"></div>
                                            <div class="select-fill">
                                                <img src="{{ asset('assets/images/Vector.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="heading-2">Lorem ipsum dolor sit amet consectet
                                            pellentesque non duis elit.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item-2" onclick="eventHandler('form-item-1', 'form-item-2')">
                                <div class="left">
                                    <div class="icon"></div>
                                </div>
                                <div class="right">
                                    <div class="item">
                                        <div class="heading-1">
                                            <div class="label">Other Fundraisers</div>
                                            <div class="select-none"></div>
                                            <div class="select-fill">
                                                <img src="{{ asset('assets/images/Vector.png')}}" alt="">
                                            </div>
                                        </div>
                                        <div class="heading-2">Lorem ipsum dolor sit amet consectet
                                            pellentesque non duis elit.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-container">
                                <button type="button" class="button-next" id="continueButton"
                                    onclick="nextStep()">Continue<img src="{{asset('assets/images/arrow-up.png')}}"
                                        alt=""></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="section-2">
            <form class="d-none register-form" method="post" id="fundraiser-form">
                        <div class="personal-info-form">
                            <div class="heading">
                                Personal Information
                            </div>
                            @error('type')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{$message}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror

                            <div class="info-form-container">
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="country">Country</label>
                                        <select class="form-select" name="country" data-flag="true">
                                            <option value="" disabled selected>Choose Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="firstName">First Name</label>
                                        <input type="text" id="firstName" name="first_name"  placeholder="First Name" required>
                                    </div>
                                    <div class="form-control">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" id="lastName" name="last_name"  placeholder="Last Name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" placeholder="Your email address" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" placeholder="Create your password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="password">Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"  placeholder="Confirm Password" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="button-container">
                            <button type="button" class="button-prev" id="prevButton" onclick="prevStep()">Go
                                Back</button>
                            <button type="submit" class="button-next" id="finishButton">Finish<i class="fa-solid fa-circle-notch rotate-icon d-none loader mx-2"></i></button>
                        </div>
            </form>

            <form class="d-none register-form" method="post" id="organizer-form">
                        <div class="personal-info-form">
                            <div class="heading">
                                Organization Information
                            </div>

                            <div class="info-form-container organization-container mt-5">
                                
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="firstName">Organization Name</label>
                                        <input type="text" id="organization_name" name="organization_name" placeholder="Organization Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="firstName">First Name</label>
                                        <input type="text" id="org-firstName" name="first_name" placeholder="First Name" required>
                                    </div>
                                    <div class="form-control">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" id="org-lastName" name="last_name" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input id="phone" type="tel" name="organization_phone" required/>
                                </div>
                                

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="organization_type">Orgainzation Type</label>
                                        <select class="form-select" name="organization_type" data-flag="true">
                                            <option value="" disabled selected>Select Organization</option>
                                            <option value="non-profit">Nonprofit</option>
                                            <option value="individual">Individual</option>
                                            <option value="commercial venture">Commercial Venture</option>
                                            <option value="political campaign">Political Campaign</option>
                                            <option value="government entity">Government Entity</option>
                                        </select>
                                    </div>
                                </div>

                            
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="organization_description">Orgainzation Description</label>
                                        <textarea class="form-control" id="organization_description" name="organization_description" placeholder="Organization Description" required></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="organization_website">Organization Website</label>
                                        <input type="text" id="organization_website" name="organization_website" placeholder="Organization Name" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" placeholder="Your email address" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" placeholder="Create your password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="password">Confirm Password</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"  placeholder="Confirm Password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="platform">How did you hear about us? (Optional)</label>
                                        <select class="form-select" id="platform" name="platform" data-flag="true">
                                            <option value="" disabled selected>Select Platform</option>
                                            <option value="non-profit">Google Search</option>
                                            <option value="individual">Google ads</option>
                                            <option value="commercial venture">Stripe</option>
                                            <option value="political campaign">Weebly</option>
                                            <option value="government entity">WordPress</option>
                                            <option value="Wix">Wix</option>
                                            <option value="Bing">Bing</option>
                                            <option value="Twitch donations">Twitch donations</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="button-container">
                            <button type="button" class="button-prev" id="prevButton" onclick="prevStep()">Go
                                Back</button>
                            <button type="submit" class="button-next" id="finishButton">Finish<i class="fa-solid fa-circle-notch rotate-icon d-none loader mx-2"></i></button>
                        </div>
            </form>
        </div>
        <div class="section-3 mt-4">
            <div class="text-1">
                Already have an account?
            </div>
            <div class="text-2">
                <a href="{{route('login')}}">Sign in</a>
            </div>
        </div>
    </div>
    <div class="section-right">
        <div class="text-section">
            <div class="text-1">Signup to</div>
            <div class="text-2">Create Your Donation Account</div>
            <div class="items">
                <div class="item">
                    <div class="icon"></div>
                    <div class="text">Lorem ipsum dolor sit amet</div>
                </div>

                <div class="item">
                    <div class="icon"></div>
                    <div class="text">Lorem ipsum dolor sit amet</div>
                </div>

                <div class="item">
                    <div class="icon"></div>
                    <div class="text">Lorem ipsum dolor sit amet</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> --}}


@endsection

@section('script')
<script>
    function eventHandler(item1, item2) {
        document.querySelector(`.${item1}`).classList.remove('active');
        document.querySelector(`.${item2}`).classList.add('active');
        updateType(item1 , item2)
      }

    function updateType(item1 , item2){
        if(item1 == 'form-item-2'){
            document.querySelector('input[name="type"]').value = '{{AppConst::NON_PROFIT_ORGANIZATION}}';
        }else{
            document.querySelector('input[name="type"]').value = '{{AppConst::FUNDRAISER}}';
        }
    }

    let currentStep = 1;
    function nextStep() {
        let type =document.querySelector('input[name="type"]').value;
        document.querySelectorAll(".dash")[0].classList.add("active")
        document.querySelectorAll(".dash")[1].classList.add("active")
        document.querySelector('input[name="type"]').value == '{{AppConst::NON_PROFIT_ORGANIZATION}}' ? document.querySelector("#organizer-form").classList.remove("d-none") : document.querySelector("#fundraiser-form").classList.remove("d-none");
        document.querySelector('#type-select-section').classList.add("d-none"); 
    }
  
    function prevStep() {
        document.querySelectorAll(".dash")[1].classList.remove("active")
        document.querySelectorAll(".dash")[0].classList.add("active")
        document.querySelector('#type-select-section').classList.remove("d-none"); 
        document.querySelector("#organizer-form").classList.add("d-none")
        document.querySelector("#fundraiser-form").classList.add("d-none")
    }



    $(document).on("submit" , ".register-form" , function(event){
        event.preventDefault();
        let element = this;
        let form = new FormData(this);
        form.append('_token' , '{{csrf_token()}}');
        form.append('type' , document.querySelector('input[name="type"]').value)
        element.querySelector(".loader").classList.remove("d-none");
        $.ajax({
            type: 'POST',
            url : '{{route("register")}}',
            data : form,
            processData : false,
            contentType: false,
            success : function(){
                element.querySelector(".loader").classList.add("d-none");
                window.location.href = "/"; 
            },
            error: function(err){
                element.querySelector(".loader").classList.add("d-none");
                let errors = err.responseJSON.errors;
                for(let key in errors){
                    let currentError = errors[key][0];
                    toastr.error(currentError);
                }
            },
        })
    })
  
    
</script>

<script>
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
  </script>
@endsection