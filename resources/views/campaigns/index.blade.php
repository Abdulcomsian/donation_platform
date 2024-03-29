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
<link rel="stylesheet" href="{{ asset('assets/css/campaign.css') }}">
@endsection

@section('content')
@if(session('toastr'))
{!! session('toastr') !!}
@endif
<div class="campaigns">
    <div class="header">
        <div class="heading">Campaigns</div>
        <div class="create-campaign">
            <a href="{{ route('campaign.create.form') }}">Create Campaign</a>
        </div>
    </div>

    <div class="data-cards">
        <div class="row">
            @foreach($campaigns as $campaign)
            <div class="col-md-4">
                <div class="card">
                    <div class="top">
                        <div class="heading">
                            <div class="text"><a href="{{url('donate-now' , $campaign->id)}}">{{$campaign->title}}</a></div>
                            <div class="menu">
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ asset('assets/images/ellipsis-vertical-sharp.png') }}" alt="">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{url('donate-now' , $campaign->id)}}" target="_blank">View</a></li>
                                        <li><a class="dropdown-item" href="{{url('campaigns/edit-campaign' , $campaign->id)}}">Edit</a></li>
                                        <li><a class="dropdown-item" href="{{url('campaigns/delete-campaign' , $campaign->id)}}">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="info">
                            <div class="days-ago">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"
                                        fill="none">
                                        <path
                                            d="M7.46102 1.61426C4.23857 1.61426 1.62769 4.22514 1.62769 7.44759C1.62769 10.67 4.23857 13.2809 7.46102 13.2809C10.6835 13.2809 13.2944 10.67 13.2944 7.44759C13.2944 4.22514 10.6835 1.61426 7.46102 1.61426ZM9.63652 8.97649L9.16609 9.56453C9.13522 9.60312 9.09705 9.63526 9.05375 9.65911C9.01046 9.68295 8.9629 9.69803 8.91377 9.70349C8.86465 9.70895 8.81493 9.70469 8.76746 9.69093C8.71999 9.67718 8.67569 9.65421 8.63709 9.62333L7.06115 8.45384C6.95104 8.36568 6.86216 8.25389 6.80108 8.12673C6.74001 7.99958 6.70831 7.86032 6.70833 7.71926V4.06049C6.70833 3.96068 6.74798 3.86496 6.81856 3.79438C6.88914 3.7238 6.98486 3.68415 7.08467 3.68415H7.83736C7.93718 3.68415 8.0329 3.7238 8.10348 3.79438C8.17406 3.86496 8.21371 3.96068 8.21371 4.06049V7.44759L9.57795 8.44725C9.61657 8.47815 9.64872 8.51634 9.67256 8.55967C9.6964 8.60299 9.71148 8.65058 9.71691 8.69973C9.72235 8.74888 9.71805 8.79862 9.70426 8.84611C9.69046 8.8936 9.66745 8.9379 9.63652 8.97649Z"
                                            fill="#CBCBCB" />
                                    </svg>
                                </div>
                                @php
                                $date = \Carbon\Carbon::createFromDate($campaign->date);
                                $today = \Carbon\Carbon::now();
                                $diffDays = $date->diffInDays($today);
                                @endphp
                                <div class="text">{{$diffDays}} Days Ago</div>
                            </div>
                            <div class="amount">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"
                                        fill="none">
                                        <path
                                            d="M8.94652 6.93262L6.48558 6.21256C6.20075 6.13053 6.00251 5.86393 6.00251 5.56771C6.00251 5.19629 6.30329 4.89551 6.67471 4.89551H8.18545C8.46344 4.89551 8.73688 4.97982 8.96475 5.13477C9.10374 5.22819 9.29059 5.2054 9.40908 5.08919L10.2021 4.31445C10.3638 4.15723 10.341 3.89518 10.161 3.75618C9.60277 3.31868 8.9055 3.07487 8.19001 3.07259V1.97884C8.19001 1.77832 8.02594 1.61426 7.82542 1.61426H7.09626C6.89574 1.61426 6.73167 1.77832 6.73167 1.97884V3.07259H6.67471C5.22321 3.07259 4.05654 4.31901 4.19098 5.79785C4.28669 6.84831 5.08877 7.7028 6.10049 7.99902L8.4361 8.68262C8.72093 8.76693 8.91917 9.03125 8.91917 9.32747C8.91917 9.69889 8.61839 9.99967 8.24697 9.99967H6.73623C6.45824 9.99967 6.1848 9.91536 5.95693 9.76042C5.81794 9.66699 5.63109 9.68978 5.5126 9.80599L4.71963 10.5807C4.55784 10.738 4.58063 11 4.76064 11.139C5.31891 11.5765 6.01618 11.8203 6.73167 11.8226V12.9163C6.73167 13.1169 6.89574 13.2809 7.09626 13.2809H7.82542C8.02594 13.2809 8.19001 13.1169 8.19001 12.9163V11.818C9.25186 11.7975 10.2476 11.1663 10.5985 10.1615C11.0884 8.75781 10.2659 7.31771 8.94652 6.93262Z"
                                            fill="#CBCBCB" />
                                    </svg>
                                </div>
                                <div class="text">{{number_format($campaign->donations->sum('amount'))}} Raised</div>
                            </div>
                        </div>
                    </div>
                    <div class="middle">
                        <img src="{{asset('assets/uploads').'/'.$campaign->image}}" alt="">
                    </div>
                    <div class="bottom">
                        <div class="progress-container">
                            @if($campaign->campaign_goal)
                            <div class="progress-bar-element">
                                @php
                                $progress = null;
                                if($campaign->donations->sum('amount') > 0){
                                $progress = $campaign->donations->sum('amount') > $campaign->amount ? 100 :
                                ceil((($campaign->donations->sum('amount'))/$campaign->amount) * 100) ;
                                }else{
                                $progress = 0;
                                }
                                @endphp
                                <progress id="fileProgress" value="{{$progress == 0 ? 1 : $progress}}"
                                    max="100"></progress>
                            </div>
                            <div class="text">{{$progress}}%</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center paginate-navigation">
                {!! $campaigns->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    document.querySelectorAll("input[type='checkbox']").forEach((item , index)=>{
        item.addEventListener("change" , function(){
            document.querySelectorAll("input[type='checkbox']").forEach( (checkbox , checkboxIndex) => {
                if(checkboxIndex != index ){
                    checkbox.checked = false;
                }
            }) 
        });
    })





</script>
@endsection