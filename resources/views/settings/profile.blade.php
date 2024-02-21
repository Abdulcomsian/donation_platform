<div class="profile">
    <div class="form-container">
        <form method="POST" action="{{route('change.profile')}}" id="profile-setting">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-name">
                        <label for="user-name">First Name</label>
                        <input type="text" id="user-name" placeholder="Jhon" value="{{$user->first_name}}" name="firstname">
                    </div>
                    <div class="form-control-name">
                        <label for="user-name">Last Name</label>
                        <input type="text" id="user-name" placeholder="Doe" value="{{$user->last_name}}" name="lastname">
                    </div>
                    <div class="form-control-email">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="johndoe@gmail.com" value="{{$user->email}}" name="email" readonly>
                    </div>
                    <div class="form-control-logo image-section">
                        <label for="logo">Profile Image</label>
                        <div class="image-upload">
                            <input type="file" class="d-none image" name="file"  onchange="onFileChange(event)">
                            <label class="label" for="image">Image</label>
                            <button type="button" onclick="importFile(event)">Upload Image</button>
                            <span class="selectFile" data-bs-toggle="tooltip" data-bs-placement="top" id="selectFile"></span>
                            <label class="info" for="">Recommended Size: 300px x 300px</label>
                        </div>
                    </div>
                    <div class="form-control-password">
                        <label for="password">Password</label>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#change-password-modal">Change
                            Password</button>
                    </div>
                    <div class="form-control-country">
                        <label for="country">Country</label>
                        <select name="country" id="country" required>
                            <option value="" selected disabled>Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{$country->id}}" @if($user->country_id == $country->id) selected @endif>{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control-number">
                        <label for="phoneNumber">Phone Number</label>
                        <input id="phone" type="tel" name="phone" value="{{$user->phone}}"/>
                    </div>
                </div>
            </div>
            <div class="submit">
                <button type="submit" class="profile-btn">Save <i class="fas fa-circle-notch fa-spin mx-2 d-none profile-loader"></i></button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="change-password-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="change-password-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="change-password-modal-label">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('change.password')}}" id="password-setting">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-container">
                                    <div class="form-control-old-password">
                                        <label for="old-password">Old Password</label>
                                        <input type="password" id="old-password" name="old_password"
                                            placeholder="Enter Old Password" required>
                                    </div>
                                    <div class="form-control-new-password">
                                        <label for="new-password">New Password</label>
                                        <div class="new-password-container">
                                            <input type="password" id="new-password" name="password"
                                                placeholder="Enter New Password" required>
                                            <div class="password-icon">
                                                <i data-feather="eye"></i>
                                                <i data-feather="eye-off"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-control-confirm-password">
                                        <label for="">Confirm Password</label>
                                        <input type="password" id="confirm-password" name="password_confirmation"
                                            placeholder="Enter Confirm Password" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-actions">
                            <button type="button" class="cancel" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="save password-btn">Save Changes<i class="fas fa-circle-notch fa-spin mx-2 d-none password-loader"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://unpkg.com/feather-icons"></script>

<script>
    feather.replace();
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    const eye = document.querySelector(".feather-eye");
    const eyeoff = document.querySelector(".feather-eye-off");
    const passwordField = document.querySelector("#new-password");

    eye.addEventListener("click", () => {
        eye.style.display = "none";
        eyeoff.style.display = "block";

        passwordField.type = "text";
    });

    eyeoff.addEventListener("click", () => {
        eyeoff.style.display = "none";
        eye.style.display    = "block";
        passwordField.type   = "password";
    });

    document.getElementById("profile-setting").addEventListener("submit" , function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let form = new FormData(this);
        let url = this.getAttribute("action");
        let loader = document.querySelector(".profile-loader");
        let submitBtn = document.querySelector(".profile-btn");
        addFormData(url , form , loader ,  null , submitBtn , null )
    })

    document.getElementById("password-setting").addEventListener("submit" , function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let form = new FormData(this);
        let url = this.getAttribute("action");
        let loader = document.querySelector(".password-loader");
        let submitBtn = document.querySelector(".password-btn");
        addFormData(url , form , loader ,  null , submitBtn , togglePasswordModal )
    })

    function togglePasswordModal(){
        $("#change-password-modal").modal("toggle")
    }

</script>