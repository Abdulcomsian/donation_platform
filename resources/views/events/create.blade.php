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
<link rel="stylesheet" href="{{ asset('assets/css/create-event.css') }}">
@endsection

@section('content')
<div class="create-event">
    <div class="header">
        <div class="heading">
            Create Event
        </div>
        <div class="route">
            <div class="pathway">
                <a class="back" href="{{ route('events') }}">Events</a>
                <div>/</div>
                <a class="active" href="{{ route('event.create.form') }}">Create Event</a>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form action="">
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
                        <label for="date">Date</label>
                        <input type="date" name="date" id="date" placeholder="Descrition...">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="time">Time</label>
                        <input type="time" name="time" id="time" placeholder="Descrition...">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="venue">Venue</label>
                        <input type="text" name="venue" id="venue" placeholder="e.g. Blue Wales">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="country">Country</label>
                        <select name="country" id="">
                            <option value="">Select Country</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="recurringEvent">Recurring Event</label>
                        <select name="recurringEvent" id="">
                            <option value="">Select Recurring</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="category">Category</label>
                        <select name="category" id="">
                            <option value="">Select Category</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="organizer">Organizer</label>
                        <input type="text" name="organizer" id="organizer" placeholder="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <div class="checkbox-wrapper">
                            <div class="custom-checkbox">
                                <input type="checkbox" name="featured" id="featured">
                            </div>
                            <label for="featured">Featured Event</label>
                        </div>
                    </div>
                </div>
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