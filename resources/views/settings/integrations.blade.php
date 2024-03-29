<div class="integrations">
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <img src="{{ asset('assets/images/Group 10191.png') }}" alt=""> Double the Donation
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="double-donation">
                        <form action="" class="form-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-control-api-key">
                                        <label for="apiKey">Api Key</label>
                                        <input type="text" id="apiKey" name="apiKey" required
                                            placeholder="Enter API Key">
                                    </div>

                                    <div class="form-control-secret-key">
                                        <label for="secertKey">Secret Key</label>
                                        <input type="text" id="secertKey" name="secertKey" required
                                            placeholder="Enter Secret Key">
                                    </div>

                                    <div class="form-control-button">
                                        <button type="submit">Save<i class="fas fa-circle-notch fa-spin mx-2 d-none mailchimp-loader"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <div class="icon">
                        <img src="{{ asset('assets/images/f3cb1bb91b2fd259ed856044b761a34b.jpeg') }}" alt="">
                    </div>Mailchimp
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <form method="post" action="{{route('integrate.mailchimp')}}" id="mailchimp-form">
                        <input type="text" name="apikey" id="apikey" placeholder="Add Api Key">
                        <button type="submit">Add</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <img src="{{ asset('assets/images/Group 10192.png') }}" alt=""> Constant Contact
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                    collapse plugin adds the appropriate classes that we use to style each element. These classes
                    control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                    modify any of this with custom CSS or overriding our default variables. It's also worth noting that
                    just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit
                    overflow.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("submit" , "#mailchimp-form" , function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let form = new FormData(this);
        let loader = this.querySelector(".mailchimp-loader");
        let url = this.getAttribute('action');
        addFormData(url , form , loader);
    })
</script>