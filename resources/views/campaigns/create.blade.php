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
@endsection

@section('content')
<div class="create-campaign">
    <div class="header">
        <div class="heading">
            Create Campaigns
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
        <form action="">
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
                        <input type="text" name="title" id="title">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="descrition">Descrition</label>
                        <textarea name="descrition" id="descrition" placeholder="Descrition..."></textarea>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="image">Image</label>
                        <div class="image-upload">
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
                        <select name="frequency" id="">
                            <option value="">Set Frequency</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="title">Recurring</label>
                        <select name="recurring" id="">
                            <option value="">Select Recurring</option>
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
                                <input type="checkbox" id="switch" /><label for="switch">Toggle</label>
                            </div>
                        </div>
                        <div class="currenct-input">
                            <span>$</span>
                            <input type="number" step="0.01" inputmode="decimal" min="0" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="feeRecovery">Fee Recovery</label>
                        <select name="feeRecovery" id="feeRecovery">
                            <option value="">Select Fee Recovery</option>
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
                <a href="{{ route('campaign.created') }}" type="submit" class="save">Save</a>
                <a href="{{ route('campaign.created') }}" type="submit" class="publish">Publish Campaign</a>
            </div>
        </form>
    </div>
</div>
<script>
    function importFile(event) {

        event.preventDefault()
  let input = document.createElement('input');
  input.type = 'file';
  input.onchange = _ => {
    // you can use this method to get file and perform respective operations
            let files =   Array.from(input.files);
            console.log(files);
        };
  input.click();
  
}
</script>
@endsection