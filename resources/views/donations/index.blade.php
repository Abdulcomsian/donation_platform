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
<link rel="stylesheet" href="{{ asset('assets/css/donation.css') }}">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{asset('assets/package/daterangepicker/daterangepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/package/select2/select2.min.css')}}">
@endsection

@section('content')
<div class="donations">
    <div class="header">
        <div class="heading">Donations</div>
        <div class="filters">
            <form>
                <div class="status-select">
                    <select name="status" id="status" aria-placeholder="Status">
                        <option value="">Status</option>
                        <option value="{{AppConst::DONATION_COMPLETED}}">{{ucfirst(AppConst::DONATION_COMPLETED)}}
                        </option>
                        <option value="{{AppConst::DONATION_FAILED}}">{{ucfirst(AppConst::DONATION_FAILED)}}</option>
                    </select>
                </div>
                <div class="campaign-select">
                    <select name="campaign" id="campaign" aria-placeholder="Status">
                        <option value="" selected>Campaign</option>
                        @foreach($campaigns as $campaign)
                        <option value="{{$campaign->id}}">{{$campaign->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="membership-select">
                    <select name="membership" id="membership" aria-placeholder="membership">
                        <option value="">Membership</option>
                    </select>
                </div>
                <div class="date-select">
                    <input type="text" name="daterange" id="daterange" placeholder="Please Enter Date Range">
                </div>
                <button type="button" class="download-btn-container">
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
                <button type="button" class="add-csv-btn-container">
                    Add CSV
                </button>
            </form>
        </div>
    </div>

    <div class="counter-cards">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="top">
                        <div class="heading">
                            <div class="heading-content">Total Donations</div>
                            <div class="tag-green">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11"
                                        fill="none">
                                        <g clip-path="url(#clip0_126_1772)">
                                            <path
                                                d="M5.32142 2.43342L3.52589 4.22952L3.52588 4.22953C3.44844 4.30696 3.34342 4.35047 3.23392 4.35047C3.12441 4.35047 3.01939 4.30696 2.94195 4.22953C2.86452 4.1521 2.82102 4.04708 2.82102 3.93757C2.82102 3.88335 2.8317 3.82966 2.85245 3.77956C2.8732 3.72947 2.90361 3.68395 2.94195 3.64561L3.01251 3.71617L2.94195 3.64561L5.44187 1.1457C5.44189 1.14568 5.44191 1.14566 5.44193 1.14564L5.32142 2.43342ZM5.32142 2.43342V9.56257C5.32142 9.67197 5.36488 9.77689 5.44223 9.85425C5.51959 9.93161 5.62451 9.97507 5.73392 9.97507C5.84332 9.97507 5.94824 9.93161 6.0256 9.85425C6.10296 9.77689 6.14641 9.67197 6.14641 9.56257V2.43342L7.94194 4.22952L7.94195 4.22953C8.01939 4.30696 8.12441 4.35047 8.23392 4.35047C8.34342 4.35047 8.44844 4.30696 8.52588 4.22953C8.60331 4.1521 8.64681 4.04708 8.64681 3.93757C8.64681 3.82806 8.60331 3.72304 8.52588 3.64561L6.02596 1.1457C6.02594 1.14568 6.02592 1.14566 6.0259 1.14564L5.32142 2.43342Z"
                                                fill="#5BC17F" stroke="#5BC17F" stroke-width="0.2" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_126_1772">
                                                <rect width="10" height="10" fill="white"
                                                    transform="translate(0.734131 0.5)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="text">
                                    10.0%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="middle">
                        <div class="amount">
                            <span class="stats-numbers">${{number_format($totalAmount , 2)}}</span>
                            <i class="fas fa-circle-notch fa-spin mx-2 d-none stats-loader"></i>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="duration">
                            <div class="month">This Month</div>
                            <div class="view">
                                <a href="">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="top">
                        <div class="heading">
                            <div class="heading-content">Rec. Donations</div>
                            <div class="tag-green">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 11 11"
                                        fill="none">
                                        <g clip-path="url(#clip0_126_1772)">
                                            <path
                                                d="M5.32142 2.43342L3.52589 4.22952L3.52588 4.22953C3.44844 4.30696 3.34342 4.35047 3.23392 4.35047C3.12441 4.35047 3.01939 4.30696 2.94195 4.22953C2.86452 4.1521 2.82102 4.04708 2.82102 3.93757C2.82102 3.88335 2.8317 3.82966 2.85245 3.77956C2.8732 3.72947 2.90361 3.68395 2.94195 3.64561L3.01251 3.71617L2.94195 3.64561L5.44187 1.1457C5.44189 1.14568 5.44191 1.14566 5.44193 1.14564L5.32142 2.43342ZM5.32142 2.43342V9.56257C5.32142 9.67197 5.36488 9.77689 5.44223 9.85425C5.51959 9.93161 5.62451 9.97507 5.73392 9.97507C5.84332 9.97507 5.94824 9.93161 6.0256 9.85425C6.10296 9.77689 6.14641 9.67197 6.14641 9.56257V2.43342L7.94194 4.22952L7.94195 4.22953C8.01939 4.30696 8.12441 4.35047 8.23392 4.35047C8.34342 4.35047 8.44844 4.30696 8.52588 4.22953C8.60331 4.1521 8.64681 4.04708 8.64681 3.93757C8.64681 3.82806 8.60331 3.72304 8.52588 3.64561L6.02596 1.1457C6.02594 1.14568 6.02592 1.14566 6.0259 1.14564L5.32142 2.43342Z"
                                                fill="#5BC17F" stroke="#5BC17F" stroke-width="0.2" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_126_1772">
                                                <rect width="10" height="10" fill="white"
                                                    transform="translate(0.734131 0.5)" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="text">
                                    3.2%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="middle">
                        <div class="amount">
                            <span class="stats-numbers">${{number_format($recievedAmount , 2)}}</span>
                            <i class="fas fa-circle-notch fa-spin mx-2 d-none stats-loader"></i>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="duration">
                            <div class="month">This Month</div>
                            <div class="view">
                                <a href="">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="top">
                        <div class="heading">
                            <div class="heading-content">Failed Donations</div>
                            <div class="tag-red">
                                <div class="icon">
                                </div>
                                <div class="text">
                                    3.0%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="middle">
                        <div class="amount">
                            <span class="stats-numbers">${{number_format($failedAmount , 2)}}</span>
                            <i class="fas fa-circle-notch fa-spin mx-2 d-none stats-loader"></i>
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="duration">
                            <div class="month">This Month</div>
                            <div class="view">
                                <a href="">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="data-table mt-5">
        <table id="donation-table">
            <thead>
                <tr>
                    <th>Donor</th>
                    <th>Campaign</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Fee Recovered</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="complete">Complete</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="complete">Complete</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="pending">Pending</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="processing">Processing</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="complete">Complete</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="complete">Complete</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="pending">Pending</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="complete">Complete</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr>
                <tr>
                    <td class="name">John Doe</td>
                    <td class="campaign">Lorem Ipsum</td>
                    <td class="status">
                        <div class="failed">Failed</div>
                    </td>
                    <td class="amount">$100</td>
                    <td class="fee-recoverd">$90</td>
                </tr> --}}
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/package/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/package/daterangepicker/daterangepicker.min.js')}}"></script>
<script src="{{asset('assets/package/select2/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function(){

    loadDonationTable();

    $("#daterange").daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#campaign').select2();

    $("#daterange").on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        this.setAttribute('data-lower-date' , picker.startDate.format("YYYY-MM-DD"));
        this.setAttribute('data-upper-date' , picker.endDate.format("YYYY-MM-DD"));
        loadDonationTable();
        loadDashboardStats();
    });

    $("#daterange").on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('')
        picker.setStartDate({});
        picker.setEndDate({});
        //relaoding datatable
        
    });

document.getElementById('status').addEventListener("change" , function(){
    loadDonationTable();
    loadDashboardStats();
})

$(document.body).on("change","#campaign",function(){
    loadDonationTable();
    loadDashboardStats();
});


function loadDonationTable(){
   let campaign = document.getElementById("campaign").value;
   let status = document.getElementById("status").value;
   let upperDate = document.getElementById("daterange").dataset.upperDate;
   let lowerDate = document.getElementById("daterange").dataset.lowerDate;
   let [ table , url , columns ] = tableInformation();
   let data = {
        campaignId : campaign,
        status : status,
        upperDate : upperDate,
        lowerDate : lowerDate
   }
   loadData(table , url , columns , data);
}


function tableInformation(){
    let table = document.getElementById("donation-table");
    let url = "{{route('get.donations')}}";
    let columns = [
                    { data: 'donar', name: 'type' },
                    { data: 'campaign', name: 'campaign' },
                    { data: 'status', name: 'status' },
                    { data: 'amount', name: 'amount' },
                    { data: 'fee_recovered', name: 'fee_recovered' },
                ];
    return [table , url , columns];
}


function loadData(table , url , columns , data){
    $(table).DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    bLengthChange: false,
                    bInfo: false,
                    pagingType: 'full_numbers',
                    "bDestroy": true,
                    ajax : {
                        type : 'POST',
                        url : url,
                        data : {
                            _token : '{{csrf_token()}}',
                            ...data
                        }
                    },
                    columns: columns
                });             
}



function loadDashboardStats(){
    let campaign = document.getElementById("campaign").value;
    let status = document.getElementById("status").value;
    let upperDate = document.getElementById("daterange").dataset.upperDate;
    let lowerDate = document.getElementById("daterange").dataset.lowerDate;
    let data = {
        campaignId : campaign,
        status : status,
        upperDate : upperDate,
        lowerDate : lowerDate
   }

   toggleStats();

    $.ajax({
        type : 'POST',
        url : '{{route("load.donation.dashboard.stats")}}',
        data : {
            _token : "{{csrf_token()}}",
            ...data
        },
        success: function(res){
            toggleStats();

            if(res.status){
                document.querySelectorAll(".stats-numbers")[0].innerHTML = res.totalAmount;
                document.querySelectorAll(".stats-numbers")[1].innerHTML = res.recievedAmount;
                document.querySelectorAll(".stats-numbers")[2].innerHTML = res.failedAmount;
            }else{
                Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: res.msg,
                    });
            }
        }
    })
}


function toggleStats(){
    document.querySelectorAll(".stats-numbers").forEach(item => {
      item.classList.contains("d-none") ? item.classList.remove("d-none") : item.classList.add("d-none") ;
   })

   document.querySelectorAll(".stats-loader").forEach(item => {
    item.classList.contains("d-none") ? item.classList.remove("d-none") : item.classList.add("d-none") ;
   })
}





})










</script>
@endsection