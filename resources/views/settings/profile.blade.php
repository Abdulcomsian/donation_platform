<div class="profile">
    <div class="form-container">
        <form action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-name">
                        <label for="user-name">Name</label>
                        <input type="text" id="user-name" placeholder="John Doe" value="John Doe" name="user-name">
                    </div>
                    <div class="form-control-email">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="johndoe@gmail.com" value="johndoe@gmail.com"
                            name="email">
                    </div>
                    <div class="form-control-password">
                        <label for="password">Password</label>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#change-password-modal">Change
                            Password</button>
                    </div>
                    <div class="form-control-country">
                        <label for="country">Country</label>
                        <select name="country" id="country">
                            <option value="">Select Country</option>
                        </select>
                    </div>
                    <div class="form-control-number">
                        <label for="phoneNumber">Phone Number</label>
                        <input id="phone" type="tel" name="phoneNumber" />
                    </div>
                </div>
            </div>
            <div class="submit">
                <button type="submit">Save</button>
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
                    <form action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-container">
                                    <div class="form-control-old-password">
                                        <label for="old-password">Old Password</label>
                                        <input type="password" id="old-password" name="old-password"
                                            placeholder="Enter Old Password" required>
                                    </div>
                                    <div class="form-control-new-password">
                                        <label for="new-password">New Password</label>
                                        <div class="new-password-container">
                                            <input type="password" id="new-password" name="new-password"
                                                placeholder="Enter New Password" required>
                                            <div class="password-icon">
                                                <i data-feather="eye"></i>
                                                <i data-feather="eye-off"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-control-confirm-password">
                                        <label for="">Confirm Password</label>
                                        <input type="password" id="confirm-password" name="confirm-password"
                                            placeholder="Enter Confirm Password" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="submit-actions">
                            <button type="button" class="cancel" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="save">Save Changes</button>
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
        eye.style.display = "block";

        passwordField.type = "password";
    });

</script>