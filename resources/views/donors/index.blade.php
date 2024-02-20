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
<style>
    button.search-btn {
    height: 48px;
    width: 61px;
    border-radius: 8px;
    border: 1px solid #DDDFE5;
    color: #949494;
}
</style>

@endsection

@section('content')
<div class="donors">
    <div class="heading">
        <div class="text">Donors</div>
        <form class="filters">
            <div class="input-date">
                <input type="date" id="date" name="date" placeholder="Date">
            </div>
            <div class="select-membership">
                <select name="membership" id="membership">
                    <option value="">Select Membership</option>
                    @if($monthlyPlans->count() > 0)
                        <optgroup label="Monthly Plans">
                            @foreach($monthlyPlans as $plan)
                            <option value="{{$plan->id}}">{{ucfirst($plan->name)}}</option>
                            @endforeach
                        </optgroup>
                    @endif
                    @if($annuallyPlans->count() > 0)
                        <optgroup label="Annually Plans">
                            @foreach($annuallyPlans as $plan)
                            <option value="{{$plan->id}}">{{ucfirst($plan->name)}}</option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>
            <div>
                <button type="button" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <div class="btn-download">
                <button type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" viewBox="0 0 27 27" fill="none">
                        <path
                            d="M17.1815 9.4375H19.2128C19.7515 9.4375 20.2681 9.65151 20.6491 10.0324C21.03 10.4134 21.244 10.93 21.244 11.4688V22.0312C21.244 22.57 21.03 23.0866 20.6491 23.4676C20.2681 23.8485 19.7515 24.0625 19.2128 24.0625H7.02527C6.48655 24.0625 5.96989 23.8485 5.58896 23.4676C5.20802 23.0866 4.99402 22.57 4.99402 22.0312V11.4688C4.99402 10.93 5.20802 10.4134 5.58896 10.0324C5.96989 9.65151 6.48655 9.4375 7.02527 9.4375H9.05652"
                            stroke="black" stroke-opacity="0.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9.05652 14.3125L13.119 18.375L17.1815 14.3125" stroke="black" stroke-opacity="0.25"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.119 2.9375V17.5625" stroke="black" stroke-opacity="0.25" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            
            <div class="btn-add-csv">
                <button type="button">Add CSV</button>
            </div>
        </form>
    </div>
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
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center paginate-navigation">
                {!! $donars->links() !!}
            </div>
        </div>
    </div>
    
</div>

@endsection

@section('script')

<script>
    document.querySelector(".search-btn").addEventListener("click" , function(e){
        let date = document.getElementById('date').value;
        let plan = document.getElementById('membership').value;

        let url = '{{url("donations/donors")}}';
        let currentUrl = `${url}?date=${date}&plan=${plan}`;
        window.location.href = currentUrl;

    })
</script>

@endsection