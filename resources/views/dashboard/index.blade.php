@extends('layouts.dashboard.main')

@section('stylesheets')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection

@section('content')

@if(session('toastr'))
{!! session('toastr') !!}
@endif

<div class="dashboard">
    <div class="header">
        <div class="left">
            <input type="file" class="d-none" name="file" id="file">
            @if($organizationProfile && $organizationProfile->logo_link)
                <img src="{{asset('assets/uploads/profile_image').'/'.$organizationProfile->logo_link}}" class="left-img" alt="">
            @else
            @if(auth()->user()->hasRole('owner'))
            <div class="upload" onclick="importFile(event)">

                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="7 7 35 35" fill="none">
                            <path d="M29.1176 21.3503L24.8061 17.1268L20.4946 21.3503" stroke="#949494" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M24.8057 27.3834V18.1827" stroke="#949494" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M33.7784 25.3291V28.9204V32.5116H15.8335V25.3291" stroke="#949494" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="text">Upload <br /> Logo</div>
                </div>
                @endif
            @endif
            <div class="heading">
                <span class="welcome">Welcome, {{auth()->user()->first_name}}!</span>
                <span class="org-name">Organization Name</span>
            </div>
        </div>
        <div class="right">
            <a href="{{ route('campaign.create.form') }}">Create Campaign</a>
        </div>
    </div>

    <div class="dashboard-counter">
        <div class="left">
            <div class="stripe-container">
                <div class="icon">
                    <img src="{{ asset('assets/images/Mask group.png') }}" alt="">
                </div>
                <div class="heading">
                    Set up Stripe To Receive Donations
                </div>
                <div class="description">
                    Lorem ipsum dolor sit amet consectetur. At fermentum augue tempor felis nisi.
                </div>


                @if(!auth()->user()->hasRole('admin'))

                    @if(auth()->user()->hasRole('owner'))

                        @if(!auth()->user()->stripe_is_verified)
                        <div class="btn-container">
                            <a href="{{route('stripe.hosted.onboarding')}}">Connect Stripe</a> 
                        </div>
                        @else

                        @if(auth()->user()->stripe_is_verified == \AppConst::STRIPE_VERIFIED)
                            <div class="btn-container">
                                <a href="{{route('remove.connected.stripe.account')}}">Disconnect Stripe</a>
                            </div>
                        @else
                            <div class="btn-container">
                                <a href="{{route('stripe.hosted.onboarding')}}">Incomplete Stripe Detail</a>
                            </div>  
                        @endif

                        @endif

                    @else
                        @if($userDetail->user->stripe_is_verified)
                            <p class="theme-text"><strong>Stripe Connected</strong></p>
                        @else
                            <p class="theme-text"><strong>No Stripe Connected</strong></p>
                        @endif
                    @endif

                @endif
            </div>

            <div class="campaign-container">
                <div class="header">
                    <div class="heading">Your Campaigns</div>
                    <div class="link">
                        <a href="{{route('campaigns')}}">View All</a>
                    </div>
                </div>

                <div class="campaigns">
                    @foreach($dashboardCampaigns as $campaign)
                    <div class="campaign">
                        <div class="card">
                            <div class="left">
                                <img src="{{ asset('assets/uploads').'/'.$campaign->image }}" alt="">
                            </div>
                            <div class="right">
                                <div class="heading">{{$campaign->title}}</div>
                                <div class="amount">
                                    @php
                                        $donationAmount = 0;
                                        
                                        
                                        foreach($campaign->donations as $donation)
                                        {
                                            if($donation->price){
                                                $donationAmount += $donation->platformPercentage->percentage > 0 ?  (($donation->price->amount) - (($donation->platformPercentage->percentage / 100) * $donation->price->amount)) : $donation->price->amount;
                                            }else{
                                                $donationAmount += $donation->platformPercentage->percentage > 0 ?  (($donation->amount) - (($donation->platformPercentage->percentage / 100) * $donation->amount)) : $donation->amount;
                                            }
                                        }

                                    @endphp
                                    <div class="collected">${{ceil($donationAmount)}} </div>
                                    @if($campaign->campaign_goal)
                                        <div class="total">/</div>
                                        <div class="total">${{ceil($campaign->amount)}}</div>
                                    @endif
                                </div>
                                @if($campaign->campaign_goal)
                                @php
                                    $percentage = ceil(($donationAmount / $campaign->amount) * 100);
                                @endphp
                                    <div class="progress-container">
                                        <div class="progress-bar-element">
                                            <progress id="fileProgress" value="{{$percentage == 0 ? 1 : $percentage}}" max="100"></progress>
                                        </div>
                                        <div class="text">{{$percentage}}% of your goal</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="right">
            <div class="card">
                <div class="total-funraised-amount">
                    <div class="left">
                        <div class="icon">
                            <img src="{{ asset('assets/images/ph_bank (1).png') }}" alt="">
                        </div>
                    </div>
                    <div class="right">
                        <div class="heading">Total Fundraised Amount</div>
                        <div class="amount">${{ number_format(ceil($recievedAmount), 2) }}</div>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="total-donations">
                    <div class="left">
                        <div class="left-icon">
                            <div class="icon">
                                <img src="{{ asset('assets/images/la_donate.png') }}" alt="">
                            </div>
                        </div>
                        <div class="right-text">
                            <div class="top">Total Donations</div>
                            <div class="bottom">{{$donationCount}}</div>
                        </div>
                    </div>
                    <div class="right">
                        <a href="{{route('donations')}}">
                            <img src="{{ asset('assets/images/chevron-down-sharp.png') }}" alt="">
                        </a>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="total-ticket-sold">
                    <div class="left">
                        <div class="left-icon">
                            <div class="icon">
                                <img src="{{ asset('assets/images/carbon_ticket.png') }}" alt="">
                            </div>
                        </div>
                        <div class="right-text">
                            <div class="top">Total Sold Tickets</div>
                            <div class="bottom">{{$purchaseTicketCount}}</div>
                        </div>
                    </div>
                    <div class="right">
                        <a href="">
                            <img src="{{ asset('assets/images/chevron-down-sharp.png') }}" alt="">
                        </a>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="new-membership">
                    <div class="left">
                        <div class="icon">
                            <img src="{{ asset('assets/images/material-symbols-light_card-membership-outline.png') }}"
                                alt="">
                        </div>
                    </div>
                    <div class="right">
                        <div class="heading">New Memberships</div>
                        <div class="amount">{{$membersCount}}</div>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="active-recurring-donors">
                    <div class="left">
                        <div class="icon">
                            <img src="{{ asset('assets/images/fluent-mdl2_recurring-event.png') }}" alt="">
                        </div>
                    </div>
                    <div class="right">
                        <div class="heading">Active Recurring Donors</div>
                        <div class="amount">{{$recurringDonor}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="latest-donors">
        <div class="header">
            <div class="left">Latest Donors</div>
            <div class="right">
                <a href="{{route('donors')}}">View All</a>
            </div>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Campaign</th>
                        <th>Status</th>
                        <th>Amount</th>
                        {{-- <th>Fee Recovered</th> --}}
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestDonations as $donation)
                    <tr>
                        <td class="name">{{$donation->donar->first_name.' '.$donation->donar->last_name}}</td>
                        <td class="campaign">{{$donation->campaign->title}}</td>
                        @if($donation->status == \AppConst::DONATION_COMPLETED)
                        <td class="status">
                            <div class="complete">Complete</div>
                        </td>
                        @elseif($donation->status == \AppConst::DONATION_PENDING)
                        <td class="status">
                            <div class="pending">Pending</div>
                        </td>
                        @elseif($donation->status == \AppConst::DONATION_PROCESSING)
                        <td class="status">
                            <div class="processing">Processing</div>
                        </td>
                        @elseif($donation->status == \AppConst::DONATION_REFUNDED)
                        <td class="status">
                            <div class="failed">REFUNDED</div>
                        </td>
                        @elseif($donation->status == \AppConst::DONATION_FAILED)
                        <td class="status">
                            <div class="failed">Failed</div>
                        </td>
                        @endif
                        @php
                        $feeAmount = $totalAmount = 0;
                        
                        if($donation->plan){
                                $feeAmount += $donation->platformPercentage->percentage > 0 ?  (($donation->plan->amount) - (($donation->platformPercentage->percentage / 100) * $donation->plan->amount)) : 0;
                                $totalAmount +=  $donation->plan->amount;
                            }else{
                                $feeAmount += $donation->platformPercentage->percentage > 0 ?  (($donation->amount) - (($donation->platformPercentage->percentage / 100) * $donation->amount)) : 0;
                                $totalAmount += $donation->amount;
                            }
                        @endphp
                        <td class="amount">${{ceil($totalAmount)}}</td>
                        {{-- <td class="fee-recoverd">${{ceil($feeAmount)}}</td> --}}
                        @php
                            $date = \Carbon\Carbon::create($donation->created_at);
                        @endphp
                        <td class="date-time">{{$date->format('d F Y h:i A')}}</td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function importFile(event) {
        event.preventDefault()
        let file = document.getElementById("file");
        file.click();

    }

    document.querySelector("#file").addEventListener("change" , function(e){
        e.preventDefault();
        let file = this.files[0];
        let form = new FormData();
        form.append('file' , file)
        form.append("_token" , "{{csrf_token()}}");
        $.ajax({
            type: "POST",
            url  : "{{route('upload.logo')}}",
            processData : false,
            contentType : false,
            data : form,
            success: function(res){
                if(res.status){
                    Swal.fire({
                            text: res.msg,
                            icon: "success"
                        });
                    loacation.reload();
                }else{
                    Swal.fire({
                        icon: "error",
                        title: res.msg,
                        text: res.error,
                    });
                }
            }
        })
    })

    


</script>
@endsection