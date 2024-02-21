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
<link rel="stylesheet" href="{{ asset('assets/css/event.css') }}">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

@endsection

@section('content')
<div class="container">
    <div class="row">
        @foreach($purchaseTicketsStats as $ticket)
        <div class="col-3">
            <label for=""><Strong>{{$ticket->name}}</Strong></label>
            @php
                $totalSold = 0; 
                foreach($ticket->users as $user){
                    $totalSold += $user->pivot->quantity;
                }
            @endphp
            <p>{{$totalSold}}</p>
        </div>
        @endforeach
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="data-table">
            <table id="tickets-table">
                <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Ticket</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>SubTotal</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
(function(){
    loadTable();
})()



function loadTable(){
        let table = document.getElementById("tickets-table");
        let url = "{{route('event.purchased.ticket')}}";
        let columns = [
                        { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                        { data: 'ticket_name', name: 'name' },
                        { data: 'user_name', name: 'email' },
                        { data: 'email', name: 'email' },
                        { data: 'quantity', name: 'quantity' },
                        { data: 'amount', name: 'amount' },
                        { data: 'total', name: 'total' },
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
                    eventId : '{{$eventId}}',
                }
            },
            columns: columns
        });  
    }
</script>
@endsection