<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="{{asset('assets/css/public-events-index.css')}}">

    <link rel="stylesheet" href="{{asset('assets/package/select2/select2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>

    <style>
        svg{
            color: #949494!important;
        }
        .grid-button:hover , .list-button:hover , .grid-button.active , .list-button.active , .search-button:hover{
            
            background-color: #5BC17F!important;

            svg{
                color: white!important;
            }
        } 


    </style>

    @yield('style')

</head>

<body>
    <div class="main">
        <!-- <div class="topbar-container">
            <div class="topbar">
                <div class="container d-flex justify-content-between">
                    <div class="logo">
                        <img src="{{$user->organizationProfile->logo_link ? asset('assets/uploads').'/'.$user->organizationProfile->logo_link : asset('assets/images/Group 2.png') }}" alt="">
                    </div>
                    <ul class="navbar-nav mr-auto d-flex justify-content-between">
                        <li class="nav-item @if(Request::is('campaign-list*')) active @endif">
                          <a class="nav-link" href="{{url('campaign-list' , \Crypt::encrypt($user->id))}}">Campaigns <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item @if(Request::is('event-list*')) active @endif">
                          <a class="nav-link" href="{{url('event-list' , \Crypt::encrypt($user->id))}}">Events</a>
                        </li>
                        <li class="nav-item @if(Request::is('membership-plans*')) active @endif">
                            <a class="nav-link" href="{{url('membership-plans' , \Crypt::encrypt($user->id))}}">Membership</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                <img src="{{$user->organizationProfile->logo_link ? asset('assets/uploads').'/'.$user->organizationProfile->logo_link : asset('assets/images/Group 2.png') }}" alt="">
                            
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item @if(Request::is('campaign-list*')) active @endif">
                        <a class="nav-link" href="{{url('campaign-list' , \Crypt::encrypt($user->id))}}">Campaigns <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item @if(Request::is('event-list*')) active @endif">
                        <a class="nav-link" href="{{url('event-list' , \Crypt::encrypt($user->id))}}">Events</a>
                    </li>
                    <li class="nav-item @if(Request::is('membership-plans*')) active @endif">
                        <a class="nav-link" href="{{url('membership-plans' , \Crypt::encrypt($user->id))}}">Membership</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        


        <div class="main-content">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="{{asset('assets/package/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('common-script')}}"></script>
    @yield('script')

</body>

</html>