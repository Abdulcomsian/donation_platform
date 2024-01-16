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

<div class="dashboard">
    <div class="header">
        <div class="left">
            <input type="file" class="d-none" name="file" id="file">
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
            <div class="heading">
                <span class="welcome">Welcome, Esther!</span>
                <span class="org-name">Organization Name</span>
            </div>
        </div>
        <div class="right">
            <a href="{{ route('campaign.create.form') }}">Create Compaign</a>
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

                <div class="btn-container">
                    <a href="">Connect Stripe</a>
                </div>
            </div>

            <div class="campaign-container">
                <div class="header">
                    <div class="heading">Your Campaigns</div>
                    <div class="link">
                        <a href="">View All</a>
                    </div>
                </div>

                <div class="campaigns">
                    <div class="campaign">
                        <div class="card">
                            <div class="left">
                                <img src="{{ asset('assets/images/26d0ba0efd3df0807e2e00c7265e76df.jpeg') }}" alt="">
                            </div>
                            <div class="right">
                                <div class="heading">Donation For Orphans</div>
                                <div class="amount">
                                    <div class="collected">$10,000</div>
                                    <div class="total">/</div>
                                    <div class="total">$20,000</div>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar-element">
                                        <progress id="fileProgress" value="20" max="100"></progress>
                                    </div>
                                    <div class="text">3% of your goal</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="campaign">
                        <div class="card">
                            <div class="left">
                                <img src="{{ asset('assets/images/365eb7a379deca9af5c01258e4a52010.jpeg') }}" alt="">
                            </div>
                            <div class="right">
                                <div class="heading">Donation For Education</div>
                                <div class="amount">
                                    <div class="collected">$8,000</div>
                                    <div class="total">/</div>
                                    <div class="total">$12,000</div>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar-element">
                                        <progress id="fileProgress" value="77" max="100"></progress>
                                    </div>
                                    <div class="text">77% of your goal</div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <div class="amount">$18,000</div>
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
                            <div class="bottom">50</div>
                        </div>
                    </div>
                    <div class="right">
                        <a href="">
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
                            <div class="top">Total Donations</div>
                            <div class="bottom">50</div>
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
                        <div class="amount">15</div>
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
                        <div class="amount">20</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="latest-donors">
        <div class="header">
            <div class="left">Latest Donors</div>
            <div class="right">
                <a href="">View All</a>
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
                        <th>Fee Recovered</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="complete">Complete</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="complete">Complete</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="pending">Pending</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="processing">Processing</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="complete">Complete</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="complete">Complete</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="pending">Pending</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="complete">Complete</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
                    <tr>
                        <td class="name">John Doe</td>
                        <td class="compaign">Lorem Ipsum</td>
                        <td class="status">
                            <div class="failed">Failed</div>
                        </td>
                        <td class="amount">$100</td>
                        <td class="fee-recoverd">$90</td>
                        <td class="date-time">02 Jan, 2024 - 12:00 AM</td>
                    </tr>
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
</script>
@endsection