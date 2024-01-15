@extends('public.donate.layout')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('assets/css/donate-now-card.css') }}">
@endsection

@section('content')
<div class="donate-now-card">
    <div class="card">
        <div class="card-top">
            <div class="heading">
                Donate Now
            </div>

            <div class="form-container">
                <form action="">
                    <div class="campaign-item">
                        <label for="campaign">Campaign</label>
                        <input type="text" value="Orphans" id="campaign" name="campaign">
                    </div>

                    <div class="amount-item">
                        <label for="amount">Select or Enter Amount</label>
                        <div class="row static-amount">
                            <div class="col-md-3">
                                <div class="item">$25</div>
                            </div>
                            <div class="col-md-3">
                                <div class="item">$50</div>
                            </div>
                            <div class="col-md-3">
                                <div class="item">$100</div>
                            </div>
                            <div class="col-md-3">
                                <div class="item">$500</div>
                            </div>
                        </div>
                        <div class="currency-input">
                            <span>$</span>
                            <input type="number" name="amount" id="amount" step="0.01" inputmode="decimal" min="0"
                                placeholder="0">
                        </div>
                    </div>

                    <div class="frequency-item">
                        <label for="frequency">Frequency</label>
                        <div class="row frequency-types">
                            <div class="col-md-6">
                                <div class="type active" id="oneTime" onclick="changeActive('oneTime', 'recurring')">
                                    <div class="text">One Time</div>
                                    <div class="icon">
                                        <img src="{{ asset('assets/images/Vector.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="type" id="recurring" onclick="changeActive('recurring', 'oneTime')">
                                    <div class="text">Recurring</div>
                                    <div class="icon">
                                        <img src="{{ asset('assets/images/Vector.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="donate-btn">
                        <button type="submit">Donate</button>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar-element">
                            <progress value="40" max="100"></progress>
                        </div>
                        <div class="text">$1000/4000</div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-bottom">
            <div class="text1">Powered By</div>
            <div class="text2">Lorem Ipsum</div>
        </div>
    </div>
</div>

<script>
    function changeActive(item1, item2) {
        document.getElementById(item1).classList.add('active')
        document.getElementById(item2).classList.remove('active')
    }
</script>
@endsection