

<div class="email-accordians">
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#donation-successful" aria-expanded="false" aria-controls="donation-successful">
                Donation Successful
            </button>
            </h2>
            <div id="donation-successful" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                    <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::DONATION_SUCCESS}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text" disabled  id="organization-name" name="organization-name" placeholder="Donation successful"
                                                value="Donation successful" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="donation-success"  class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Donation Successful Description">{{isset($user->donationSuccessMail) ? $user->donationSuccessMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch fa-spin rotate-icon d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#new-donation-subscription" aria-expanded="false" aria-controls="new-donation-subscription">
                New Donation Subscription
            </button>
            </h2>
            <div id="new-donation-subscription" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::SUBSCRIPTION_SUCCESS}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text" disabled id="organization-name" name="organization-name" placeholder="New Donation Subscription"
                                                value="New Donation Subscription" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="new-donation-sub" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter New Donation Subscription Description">{{isset($user->subscriptionSuccessMail) ? $user->subscriptionSuccessMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch fa-spin  rotate-icon d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#donations-subscription-failed" aria-expanded="false" aria-controls="donations-subscription-failed">
                    Donation subscription failed
                </button>
            </h2>
            <div id="donations-subscription-failed" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::SUBSCRIPTION_FAILED}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text" disabled   id="organization-name" name="organization-name" placeholder="Donation subscription failed"
                                                value="Donation subscription failed" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="donations-sub-failed" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Donation subscription failed Description">{{isset($user->subscriptionFailedMail) ? $user->subscriptionFailedMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch  fa-spin rotate-icon d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#donation-refund" aria-expanded="false" aria-controls="donation-refund">
                    Donation refund
                </button>
            </h2>
            <div id="donation-refund" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::DONATION_REFUND}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text"  disabled  id="organization-name" name="organization-name" placeholder="Donation refund"
                                                value="Donation refund" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="donation-ref" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Donation refund Description">{{isset($user->donationRefundMail) ? $user->donationRefundMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch  fa-spin rotate-icon d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#donation-subscription-cancelled" aria-expanded="false" aria-controls="donation-subscription-cancelled">
                    Donation subscription cancelled
                </button>
            </h2>
            <div id="donation-subscription-cancelled" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::DONATION_SUBSCRIPTION_CANCELED}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text"  disabled  id="organization-name" name="organization-name" placeholder="Donation subscription cancelled"
                                                value="Donation subscription cancelled" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="donation-sub-cancelled" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Donation subscription cancelled Description">{{isset($user->subscriptionCanceledMail) ? $user->subscriptionCanceledMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch  fa-spin rotate-icon d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#new-membership" aria-expanded="false" aria-controls="new-membership">
                    New Membership
                </button>
            </h2>
            <div id="new-membership" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::NEW_MEMBERSHIP}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text"  disabled  id="organization-name" name="organization-name" placeholder="New Membership"
                                                value="New Membership" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="new-member" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter New Membership Description">{{isset($user->membershipSubscriptionMail) ? $user->membershipSubscriptionMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch  fa-spin rotate-icon d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#member-renewal-success" aria-expanded="false" aria-controls="member-renewal-success">
                    Membership renewal success
                </button>
            </h2>
            <div id="member-renewal-success" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::MEMBERSHIP_RENEWEL_SUCCESS}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text" disabled  id="organization-name" name="organization-name" placeholder="Membership renewal success"
                                                value="Membership renewal success" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="member-renew-success" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Membership renewal success Description">{{isset($user->membershipRenewelMail) ? $user->membershipRenewelMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch rotate-icon  fa-spin d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#membership-cancelled" aria-expanded="false" aria-controls="membership-cancelled">
                    Membership cancelled
                </button>
            </h2>
            <div id="membership-cancelled" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::MEMBERSHIP_CANCELED}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text"  disabled  id="organization-name" name="organization-name" placeholder="Membership cancelled"
                                                value="Membership cancelled" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="membership-cancel" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Membership cancelled Description">{{isset($user->membershipCanceledMail) ? $user->membershipCanceledMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch rotate-icon  fa-spin d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#membership-renewal-failed" aria-expanded="false" aria-controls="membership-renewal-failed">
                    Membership renewal failed
                </button>
            </h2>
            <div id="membership-renewal-failed" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::MEMBERSHIP_RENEWEL_FAILED}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text" disabled  id="organization-name" name="organization-name" placeholder="Membership renewal failed"
                                                value="Membership renewal failed" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="membership-renew-failed" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Membership renewal failed Description">{{isset($user->membershipRenewelFailedMail) ? $user->membershipRenewelFailedMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch rotate-icon  fa-spin d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#membership-refund" aria-expanded="false" aria-controls="membership-refund">
                    Membership refund
                </button>
            </h2>
            <div id="membership-refund" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::MEMBERSHIP_REFUND}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text" disabled id="organization-name" name="organization-name" placeholder="Membership refund"
                                                value="Membership refund" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="membership-ref" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Membership refund Description">{{isset($user->membershipRefundMail) ? $user->membershipRefundMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch rotate-icon  fa-spin d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#event-registration" aria-expanded="false" aria-controls="event-registration">
                    Event registration
                </button>
            </h2>
            <div id="event-registration" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::EVENT_REGISTRATION}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text"  disabled  id="organization-name" name="organization-name" placeholder="Event registration"
                                                value="Event registration" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="event-register" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Event registration Description">{{isset($user->eventRegistrationMail) ? $user->eventRegistrationMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch rotate-icon  fa-spin d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#event-cancelled" aria-expanded="false" aria-controls="event-cancelled">
                    Event cancelled
                </button>
            </h2>
            <div id="event-cancelled" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::EVENT_CANCELED}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text"  disabled  id="organization-name" name="organization-name" placeholder="Event cancelled"
                                                value="Event cancelled" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="event-cancel" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Event cancelled Description">{{isset($user->eventCanceledMail) ? $user->eventCanceledMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch rotate-icon  fa-spin d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#event-ticket-refund" aria-expanded="false" aria-controls="event-ticket-refund">
                    Event ticket refund
                </button>
            </h2>
            <div id="event-ticket-refund" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                <div class="organization">
                        <div class="form-container">
                            <form method="POST" action="{{route('update.email.template')}}" class="email-template">
                                <input type="hidden" name="type" value="{{\AppConst::EVENT_TICKET_REFUND}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-control-name">
                                            <label for="organization-name">Subject</label>
                                            <input type="text"  disabled  id="organization-name" name="organization-name" placeholder="Event ticket refund"
                                                value="Event ticket refund" required>
                                        </div>
                                        <div class="form-control-description">
                                            <textarea name="description" id="event-ticket-ref" class="summernote"
                                                value="Lorem ipsum dolor sit amet consectetur. Eget risus massa semper maecenas bibendum. Morbi volutpat varius vel blandit senectus."
                                                placeholder="Enter Event ticket refund Description">{{isset($user->eventTicketRefundMail) ? $user->eventTicketRefundMail->html_content : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit">
                                    <button type="submit">Save Template<i class="fa-solid fa-circle-notch rotate-icon  fa-spin d-none loader mx-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#donation-ref').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough']],
                        ['fontsize', ['']],
                        ['color', ['']],
                        ['para', ['ul', 'ol', '']],
                        ['height', ['']],
                        ['picture']
                    ]
            });

        $('#donation-success').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ],
           code : ""
        });
        $('#new-donation-sub').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#donations-sub-failed').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#donation-sub-cancelled').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#new-member').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#member-renew-success').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#membership-cancel').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#membership-renew-failed').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#membership-ref').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#event-register').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
        $('#event-cancel').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });;
        $('#event-ticket-ref').summernote({
            tabsize: 2,
            height: 300,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough']],
                ['fontsize', ['']],
                ['color', ['']],
                ['para', ['ul', 'ol', '']],
                ['height', ['']],
                ['picture'],
                ['view', ['fullscreen', 'codeview']],
            ]
        });
    });


    $(document).on("submit" , ".email-template" , function(e){
        e.preventDefault();
        e.stopImmediatePropagation();
        let form = new FormData(this);
        let url = this.getAttribute('action')
        let loader = this.querySelector(".loader");
        addFormData(url , form , loader)
    })



</script>