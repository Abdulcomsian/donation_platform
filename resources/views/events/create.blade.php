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
<script src="{{asset('assets/package/validator/validator.js')}}"></script>
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
        <form id="event-form" action="{{route('create.event')}}" >
            <div class="row">
                <div class="col-12">
                    <div class="form-control">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" placeholder="Title...">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="descrition">Descrition</label>
                        <textarea name="description" id="description" placeholder="Description..."></textarea>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="image">Image</label>
                        <div class="image-upload">
                            <input type="file" class="d-none" name="file" id="file" onchange="onFileChange(event)">
                            <label class="label" for="image">Image</label>
                            <button onclick="importFile(event)">Upload Image</button>
                            <span class="selectFile" data-bs-toggle="tooltip" data-bs-placement="top"
                                id="selectFile"></span>
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
                            <option value="" disabled selected>Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="frequency">Recurring Event</label>
                        <select name="frequency" id="">
                            <option value="" selected disabled>Select Recurring</option>
                            <option value="">None</option>
                            @foreach($frequencies as $frequency)
                                <option value="{{$frequency->id}}">{{$frequency->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-control">
                        <label for="category">Category</label>
                        <select name="category" id="">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->title}}</option>
                            @endforeach
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

            <div class="tickets">
                <div class="row">
                    <div class="col-md-10">
                        <div class="heading">
                            Tickets & Pricing
                        </div>
                    </div>
                </div>

                <div class="ticket-form-fields" id="ticket-form-container">
                    <div class="row wrapper-element ticket-container">
                            <div class="col-md-5">
                                <div class="left">
                                    <div class="form-control">
                                        <label for="name">Name</label>
                                        <input type="text" class="name">
                                    </div>
                                    <div class="form-control">
                                        <label for="quantity">Ticket Quantity</label>
                                        <input type="number" step="1" min="0" placeholder="100"  class="quantity">
                                    </div>
                                    <div class="form-control">
                                        <label for="price">Ticket Price</label>
                                        <div class="checkbox-wrapper">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" class="freeTicket">
                                            </div>
                                            <label for="freeTicket">Ticket is Free</label>
                                        </div>
                                        <input type="number" step="1" min="0" placeholder="100" class="price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="right">
                                    <div class="form-control">
                                        <label for="descrition">Descrition</label>
                                        <textarea name="description" class="description" placeholder="Descrition..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="divider">
                                </div>
                            </div>


                    </div>
                </div>
            </div>

            <div class="buttons">
                <div class="row">
                    <div class="col-md-10">
                        <div class="button-container">
                            <button id="add-fields" class="add" type="button">Add Another Ticket Type</button>
                            <button class="create submit-btn" type="submit">Create Event <i class="fas fa-circle-notch fa-spin mx-2 d-none event-loader"></i></button>
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
        let file = document.getElementById("file");
        file.click();
    }

    function deleteElement(event) {
        event.preventDefault();
        event.target.closest('.ticket-container').remove();
    }

    function onFileChange(event) {
        event.preventDefault();
        const file = event.target.files[0];

        const element = document.getElementById('selectFile');
        element.innerHTML = file.name;
        element.title = file.name;
    }

    document.querySelector("#add-fields").addEventListener('click', function(e) {
        e.preventDefault();

        var newDiv = document.createElement('div');
        newDiv.className = 'row wrapper-element ticket-container';

        newDiv.innerHTML = `<div class="col-md-5">
                                <div class="left">
                                    <div class="form-control">
                                        <label for="name">Name</label>
                                        <input type="text" class="name">
                                    </div>
                                    <div class="form-control">
                                        <label for="quantity">Ticket Quantity</label>
                                        <input type="number" step="1" min="0" placeholder="100" class="quantity">
                                    </div>
                                    <div class="form-control">
                                        <label for="price">Ticket Price</label>
                                        <div class="checkbox-wrapper">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" class="freeTicket">
                                            </div>
                                            <label for="freeTicket">Ticket is Free</label>
                                        </div>
                                        <input type="number" step="1" min="0" placeholder="100" class="price">
                                    </div>
                                </div>
                            </div>
                                <div class="col-md-5">
                                    <div class="right">
                                        <div class="form-control">
                                            <label for="descrition">Descrition</label>
                                            <textarea name="description" class="description" placeholder="Descrition..."></textarea>
                                        </div>

                                        <div class="delete-element-container">
                                            <button onclick="deleteElement(event)" class="btn--delete">Delete</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-10">
                                    <div class="divider">
                                    </div>
                                </div>`;

                            document.getElementById('ticket-form-container').appendChild(newDiv);
    })



    $(document).on("change" , ".freeTicket" , function(){
        
        if(this.checked == true){
                let price = this.closest(".ticket-container").querySelector(".price");
                price.setAttribute("disabled" , true)
                price.value = 0;
            }else{
                let price = this.closest(".ticket-container").querySelector(".price");
                price.removeAttribute("disabled")
            }

    })

    $(document).on("submit" , "#event-form" , function(e){
        e.preventDefault();
        let loader = this.querySelector(".event-loader");
        let form = new FormData(this);
        let ticketContainer = document.querySelectorAll(".ticket-container");
        let tickets = [];
        let errors = null;
        let errorFlag = false;
        ticketContainer.forEach(container => {
            let name = container.querySelector(".name").value;
            let description = container.querySelector(".description").value;
            let quantity = container.querySelector(".quantity").value;
            let isFree = container.querySelector(".freeTicket").checked == true ? 1 : 0;
            let amount = container.querySelector(".price").value;

            let ticketDetail = { 
                                 name : name , 
                                 description : description, 
                                 quantity : quantity , 
                                 isFree : isFree,
                                 amount : amount,
                            }
                            
            let errors = null;
            for(const keyElement in ticketDetail){
                const value = ticketDetail[keyElement].toString();
                if(validator.isEmpty(value)){
                    let key = keyElement.replace(/_/g, ' ');
                    errors === null ? errors = `${key} must Be Required` : errors += `, ${key} must Be Required`;
                    errorFlag = true;
                }

            }

            if(errors !== null)
            {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errors+=".",
                });
                return;
            }

            console.log(ticketDetail);
            tickets.push(ticketDetail);
            
        })
        if(!errorFlag){
            let url = "{{route('create.event')}}";
            form.append('tickets' , JSON.stringify(tickets));
            let submitBtn = this.querySelector(".submit-btn");
            let redirectUrl = "{{route('event.created')}}";
            addFormData(url , form , loader , redirectUrl , submitBtn , null );
        }else{
            alert(errorFlag);
        }


    })




</script>
@endsection