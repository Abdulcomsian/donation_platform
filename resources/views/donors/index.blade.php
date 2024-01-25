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
<link rel="stylesheet" href="{{ asset('assets/css/donor.css') }}">
@endsection

@section('content')
<div class="donors">
    <div class="heading">Donors</div>
    <div class="datatable">
        <table>
            <thead>
                <tr>
                    <th>Recent Donor</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($donars) --}}
                @foreach($donars as $donation)
                <tr>
                    <td class="name">{{$donation->donar->first_name.' '.$donation->donar->last_name}}</td>
                    <td class="amount">${{$donation->amount ? $donation->amount : $donation->price->amount}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

