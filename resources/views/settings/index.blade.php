@extends('layouts.dashboard.main')

@section('stylesheets')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<style>
    .admin .header{
        position: relative;
    }
    .admin .header .add-btn-container {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
    }
</style>

@endsection

@section('content')
<div class="settings">
    <div class="heading">
        Settings
    </div>

    <div class="tabs-container">
        <div class="row">
            <div class="col-md-10">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="true">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-organization-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-organization" type="button" role="tab"
                            aria-controls="pills-organization" aria-selected="false">Organization</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-admin-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-admin" type="button" role="tab" aria-controls="pills-admin"
                            aria-selected="false">Admin</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-emails-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-emails" type="button" role="tab" aria-controls="pills-emails"
                            aria-selected="false">Emails</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-integrations-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-integrations" type="button" role="tab"
                            aria-controls="pills-integrations" aria-selected="false">Integrations</button>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                        aria-labelledby="pills-profile-tab">
                        @include('settings.profile')
                    </div>
                    <div class="tab-pane fade" id="pills-organization" role="tabpanel"
                        aria-labelledby="pills-organization-tab">
                        @include('settings.organization')
                    </div>
                    <div class="tab-pane fade" id="pills-admin" role="tabpanel" aria-labelledby="pills-admin-tab">
                        @include('settings.admin')
                    </div>
                    <div class="tab-pane fade" id="pills-emails" role="tabpanel" aria-labelledby="pills-emails-tab">
                        @include('settings.emails')
                    </div>
                    <div class="tab-pane fade" id="pills-integrations" role="tabpanel"
                        aria-labelledby="pills-integrations-tab">
                        @include('settings.integrations')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    function importFile(event) {
        event.preventDefault()
        let fileSection = event.target.closest(".image-section");
        fileSection.querySelector(".image").click();
    }

    function onFileChange(event) {
        event.preventDefault();
        const file = event.target.files[0];
        const fileSection = event.target.closest(".image-section")
        const element = fileSection.querySelector('.selectFile');
        element.innerHTML = file.name;
        element.title = file.name;
    }

    $(document).on("click" , "#pills-admin-tab" , function(e){
        loadTable();
    })

    function loadTable(){
        let table = document.getElementById("user-table");
        let url = "{{route('user.list')}}";
        let columns = [
                        { data: 'name', name: 'name' },
                        { data: 'email', name: 'email' },
                        { data: 'role', name: 'role' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action' },
                    ];
        $(table).DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            bLengthChange: false,
            bInfo: false,
            pagingType: 'full_numbers',
            "bDestroy": true,
            ajax : {
                type : 'POST',
                url : url,
                data : {
                    _token : '{{csrf_token()}}',
                }
            },
            columns: columns
        });  
    }

</script>
@endsection