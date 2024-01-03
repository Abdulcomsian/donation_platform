@extends('layouts.app')

@section('stylesheets')
<link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
                <div id="stepper">
                    <div class="step" id="step1" style="display: block;">
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
                                        {{-- <select class="selectpicker countrypicker" data-flag="true"></select> --}}
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

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> --}}

<script>
    function eventHandler(item1, item2) {
        document.querySelector(`.${item1}`).classList.remove('active');
        document.querySelector(`.${item2}`).classList.add('active');
      }
</script>

<script>
    let currentStep = 1;
    
    function nextStep() {
      document.getElementById(`step${currentStep}`).style.display = 'none';
      currentStep++;
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
</script>
@endsection