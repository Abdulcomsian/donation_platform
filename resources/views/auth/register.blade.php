@extends('layouts.app')

@section('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
@endsection

@section('content')
<div class="register">
    <div class="section-left">
        <div class="section-1">
            <div class="dash active"></div>
            <div class="dash"></div>
        </div>
        <div class="section-2">
            <form onsubmit="finish()">
                <div class="stepper" id="stepper">
                    <div class="step" id="step1" style="display: block;">
                        <div class="type-selection">
                            <div class="text">How are you planning to raise funds?</div>
                            <div class="form-container">
                                <div class="form-item-1 active"
                                    onclick="eventHandler('form-item-2', 'form-item-1', 'non-profit')">
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
                                <div class="form-item-2" onclick="eventHandler('form-item-1', 'form-item-2', 'other')">
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
                            </div>
                        </div>

                        <div class="button-container">
                            <button type="button" class="button-next" id="continueButton"
                                onclick="nextStep()">Continue<img src="{{asset('assets/images/arrow-up.png')}}"
                                    alt=""></button>
                        </div>
                    </div>
                    <div class="step" id="step2" style="display: none;">
                        <div class="personal-info-form">
                            <div class="heading">
                                Personal Information
                            </div>
                            <div class="info-form-container">
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="country">Country</label>
                                        <select name="country" id="country">
                                            <option value="">United States</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="firstName">First Name</label>
                                        <input type="text" id="firstName" placeholder="First Name" required>
                                    </div>
                                    <div class="form-control">
                                        <label for="lastName">Last Name</label>
                                        <input type="text" id="lastName" placeholder="Last Name" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" placeholder="Your email address" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" placeholder="Create your password"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="organization-information-form">
                            <div class="heading">Organization Information</div>
                            <div class="form-container">
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="organizationName">Organization Name *</label>
                                        <input type="text" id="organizationName" placeholder="Enter organization name"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="firstName">First Name *</label>
                                        <input type="text" id="firstName" name="firstName" placeholder="First Name"
                                            required>
                                    </div>
                                    <div class="form-control">
                                        <label for="lastName">Last Name *</label>
                                        <input type="text" id="lastName" name="lastName" placeholder="Last Name"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="phoneNumber">Phone Number *</label>
                                        <input type="tel" name="phoneNumber" id="phoneNumber">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="organizationType">Organization Type *</label>
                                        <select name="organizationType" id="organizationType">
                                            <option value="">United States</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="organizationDescription">Organization Description *</label>
                                        <textarea name="organizationDescription" id="organizationDescription" cols="30"
                                            rows="5" placeholder="Description..."></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="organizationWebsite">Organization Website</label>
                                        <input type="text" name="organizationWebsite" id="organizationWebsite"
                                            placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="email">Email *</label>
                                        <input type="email" id="email" placeholder="Your email address" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="password">Password *</label>
                                        <input type="password" id="password" placeholder="Create your password"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label for="aboutUs">How did you hear about us?</label>
                                        <select name="aboutUs" id="aboutUs">
                                            <option value="">United States</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-container">
                            <button type="button" class="button-prev" id="prevButton" onclick="prevStep()">Go
                                Back</button>
                            <button type="submit" class="button-next" id="finishButton">Finish</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="section-3">
            <div class="text-1">
                Already have an account?
            </div>
            <div class="text-2">
                <a href="">Sign in</a>
            </div>
        </div>
    </div>
    <div class="section-right">
        <div class="text-section">
            <div class="text-1">Sign up to</div>
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

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script>
    const input = document.querySelector("#phoneNumber");
  window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
  });
</script>

<script>
    let currentStep = 1;
    const dashes = document.querySelectorAll(".dash");
    
    function nextStep() {
      document.getElementById(`step${currentStep}`).style.display = 'none';
      currentStep++;
      dashes[currentStep - 1].classList.add('active')
      document.getElementById(`step${currentStep}`).style.display = 'block';
  
      if (currentStep === 2) {
        document.getElementById('prevButton').style.display = 'block';
        document.getElementById('continueButton').style.display = 'none';
        document.getElementById('finishButton').style.display = 'block';
      }
    }
  
    function prevStep() {
      document.getElementById(`step${currentStep}`).style.display = 'none';
      currentStep--;
      dashes.forEach(element => {
        element.classList.remove('active')
      });
      dashes[currentStep - 1].classList.add('active')
      document.getElementById(`step${currentStep}`).style.display = 'block';
  
      if (currentStep === 1) {
        document.getElementById('prevButton').style.display = 'none';
        document.getElementById('continueButton').style.display = 'block';
        document.getElementById('finishButton').style.display = 'none';
      }
    }
  
    function finish() {
      alert('Finish Action');
    }

    let type = 'non-profit';
    document.querySelector('.personal-info-form').hidden = false;
    document.querySelector('.organization-information-form').hidden = true;

    function eventHandler(item1, item2, fundType) {
        if (fundType === 'non-profit') {
            type = fundType
            document.querySelector('.personal-info-form').hidden = false;
            document.querySelector('.organization-information-form').hidden = true;
        }else if (fundType === 'other') {
            type = fundType
            document.querySelector('.personal-info-form').hidden = true;
            document.querySelector('.organization-information-form').hidden = false;
        }
        document.querySelector(`.${item1}`).classList.remove('active');
        document.querySelector(`.${item2}`).classList.add('active');
    }
</script>
@endsection