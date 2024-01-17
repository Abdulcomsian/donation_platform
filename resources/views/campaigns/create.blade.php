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
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/create-campaign.css') }}">
<link rel="stylesheet" href="{{asset('assets/package/select2/select2.min.css')}}"  />
@endsection

@section('content')
<div class="create-campaign">
    <div class="header">
        <div class="heading">
            Create Campaign
        </div>
        <div class="route">
            <div class="pathway">
                <a class="back" href="{{ route('campaigns') }}">Campaigns</a>
                <div>/</div>
                <a class="active" href="{{ route('campaign.create.form') }}">Create Campaign</a>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form method="post" class="campaign-form">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="title">Campaign Title</label>
                        <input type="text" name="title" id="title" placeholder="Campaign Name">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="">Excerpt</label>
                        <input type="text" name="excerpt" id="title" >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="descrition">Description</label>
                        <textarea name="description" id="description" placeholder="Descrition..."></textarea>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="image">Image</label>
                        <div class="image-upload">
                            <input type="file" class="d-none" name="file" id="file">
                            <label class="label" for="image">Image</label>
                            <button onclick="importFile(event)">Upload Image</button>
                            <label class="info" for="">Recommended Size: 530px x 530px</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="title">Frequency</label>
                        <select id="frequency" multiple="multiple">
                            <option value="" disabled>Set Frequency</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="annually">Annually</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="title">Recurring</label>
                        <select name="recurring" id="">
                            <option value="" disabled selected>Select Recurring</option>
                            <option value="disable">Disable</option>
                            <option value="optional">Optional</option>
                            <option value="required">Required</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <div class="toggler-label">
                            <label for="">Campaign Goal</label>
                            <div class="toggler">
                                <input type="checkbox" class="campaign-goal-toggle" name="campaign_goal" id="switch" value="1"/><label for="switch">Toggle</label>
                            </div>
                        </div>
                        <div class="currency-input campaign-goal d-none">
                            <span>$</span>
                            <input type="number" step="0.01" inputmode="decimal" name="amount"  min="0" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control campaign-goal d-none">
                        <label for="feeRecovery">Fee Recovery</label>
                        <select name="fee_recovery" id="feeRecovery">
                            <option value="">Select Fee Recovery</option>
                            <option value="disable">Disable</option>
                            <option value="optional">Optional</option>
                            <option value="required">Required</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <input type="datetime-local" id="date" name="date">
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button class="btn submit" type="submit" class="save">Save <i class="fas fa-circle-notch fa-spin mx-2 d-none submit-loader"></i></button>
                <button class="publish" type="button">Publish Campaign<i class="fas fa-circle-notch fa-spin mx-2 d-none publish-loader"></i></button>
            </div>
        </form>
    </div>
</div>
<script src="{{asset('assets/package/select2/select2.full.min.js')}}"></script>
<script>
    function importFile(event) {

        event.preventDefault()
        let file = document.getElementById("file");
        file.click();
  
    }
    $('#frequency').select2();

    $(document).on("change" , ".campaign-goal-toggle" , function(e){
        let element = this;
        if(element.checked == true){
            document.querySelectorAll(".campaign-goal").forEach(item => {
                item.classList.remove("d-none");
            })
        }else{
            document.querySelectorAll(".campaign-goal").forEach(item => {
                item.classList.add("d-none");
            })
        }
    })


    document.querySelector(".campaign-form").addEventListener("submit" , function(e){
        
        e.preventDefault();
        let submitBtn = this.querySelector(".submit");
        let frequency = $("#frequency").val().join(",");
        let loader = document.querySelector(".submit-loader");
        let form = new FormData(this);
        form.append("frequency" , frequency);
        form.append('status' , 0 );
        url = '{{route("create.campaign")}}';
        redirectUrl = "{{route('campaign.created')}}";
        addFormData(url , form , loader , redirectUrl , submitBtn );

    })


    document.querySelector(".publish").addEventListener("click" , function(e){
        
        e.preventDefault();
        let publishBtn = document.querySelector(".publish");
        let frequency = $("#frequency").val().join(",");
        let loader = document.querySelector(".publish-loader");
        let form = new FormData(document.querySelector(".campaign-form"));
        form.append("frequency" , frequency);
        form.append('status' , 1 );
        url = '{{route("create.campaign")}}';
        redirectUrl = "{{route('campaign.created')}}";
        addFormData(url , form , loader , redirectUrl , publishBtn );

    })


    


</script>
@endsection