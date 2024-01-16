<div class="profile">
    <div class="form-container">
        <form action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-control-name">
                        <label for="name">Name</label>
                        <input type="text" id="name" placeholder="John Doe" value="John Doe" name="name">
                    </div>
                    <div class="form-control-email">
                        <label for="email">Email</label>
                        <input type="email" id="email" placeholder="johndoe@gmail.com" value="johndoe@gmail.com"
                            name="email">
                    </div>
                    <div class="form-control-password">
                        <label for="password">Password</label>
                        <button type="button">Change Password</button>
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
</div>

<script>
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
      utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });
</script>