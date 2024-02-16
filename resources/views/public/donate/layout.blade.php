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
    <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{asset('assets/package/validator/validator.js')}}"></script>
    
    <link rel="stylesheet" href="{{asset('assets/css/donate-now-layout.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{asset('assets/package/sweet-alert/sweet-alert.min.js')}}"></script>
    <style>
        .donation-amount-box.active .donation-amount{
            color: white!important;
            background: #5BC17F;
        }

        select.form-select {
            height: 60px;
            border: 1px solid #E5E5E5;
            border-radius: 13px;
        }

        .back-btn{
            cursor: pointer;
            transition: 0.2s ease-in-out;
            padding: 0px 7px;
        }

        .back-btn:hover{
            color: #5BC17F;
        }
    </style>
</head>

<body>
    <div class="donate-noe-layout">
        <div class="container-fluid rectangle">
            <div class="container header">
                <div class="main">
                    <div class="icon">
                        <img src="{{ asset('assets/images/Group 2 (1).png') }}" alt="">
                    </div>
                    @if(auth()->check())
                    <div class="profile">
                        <div class="items">
                            <div class="notification">
                                <div class="notification-circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="21" viewBox="0 0 19 21"
                                        fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16.6995 7.63851C16.7488 7.97653 16.774 8.31918 16.774 8.66396V13.4261L18.6314 16.2123C18.7333 16.365 18.7918 16.5425 18.8007 16.7258C18.8096 16.9091 18.7686 17.0915 18.682 17.2533C18.5954 17.4151 18.4665 17.5504 18.309 17.6448C18.1515 17.7391 17.9714 17.7889 17.7879 17.7889H13.1899C13.0678 18.6335 12.6455 19.4059 12.0003 19.9646C11.3551 20.5232 10.5303 20.8307 9.67682 20.8307C8.82338 20.8307 7.9985 20.5232 7.35331 19.9646C6.70812 19.4059 6.2858 18.6335 6.16373 17.7889H1.56579C1.38223 17.7889 1.20211 17.7391 1.04465 17.6448C0.887178 17.5504 0.75827 17.4151 0.671675 17.2533C0.58508 17.0915 0.544047 16.9091 0.552952 16.7258C0.561858 16.5425 0.620368 16.365 0.722241 16.2123L2.57967 13.4261V8.66396C2.57967 5.39521 4.78992 2.64152 7.79709 1.81825C7.94857 1.44384 8.20842 1.12319 8.54332 0.897418C8.87823 0.671643 9.27292 0.551025 9.67682 0.551025C10.0807 0.551025 10.4754 0.671643 10.8103 0.897418C11.0737 1.07498 11.2907 1.31123 11.445 1.58615C10.9569 2.16345 10.6273 2.87899 10.5232 3.66569C10.2453 3.61865 9.96232 3.59457 9.67682 3.59457C8.33233 3.59457 7.04291 4.12866 6.09222 5.07936C5.14152 6.03005 4.60742 7.31947 4.60742 8.66396V13.7334C4.60747 13.9336 4.5482 14.1294 4.43709 14.2961L3.46073 15.7611H15.8919L14.9155 14.2961C14.8048 14.1293 14.7459 13.9335 14.7462 13.7334V8.66396C14.7462 8.52673 14.7406 8.39009 14.7296 8.25431C15.4515 8.22168 16.1241 8.00036 16.6995 7.63851ZM8.79893 18.5242C8.54207 18.3425 8.34791 18.0856 8.2432 17.7889H11.1115C11.0067 18.0856 10.8126 18.3425 10.5557 18.5242C10.2989 18.706 9.99197 18.8036 9.67733 18.8036C9.36268 18.8036 9.05578 18.706 8.79893 18.5242Z"
                                            fill="#212121" />
                                    </svg>
                                </div>
                            </div>
                            @if(auth()->check())
                            <div class="profile-section">
                                <div class="profile-info">
                                    <div class="profile-icon">
                                        <img src="{{ auth()->user()->profile_image ? asset('assets/uploads').'/'.auth()->user()->profile_image : asset('assets/images/human-profile.png') }}" alt="">
                                    </div>
                                    <div class="profile-name">{{ auth()->user()->first_name }}</div>
                                    <div class="caret-drop">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16.3161 9.08936L12.2128 13.1927L8.10936 9.08936L6.75781 10.4409L12.2128 15.8958L17.6677 10.4409L16.3161 9.08936Z"
                                                fill="white" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="container donate-now-container">
                <div class="left">
                    <div class="title">{{$campaign->title}}</div>
                    <div class="description">
                        {{$campaign->description}}
                    </div>
                    <div class="icon">
                        <img src="{{ asset('assets/images/26d0ba0efd3df0807e2e00c7265e76df.jpeg') }}" alt="">
                    </div>
                </div>
                <div class="right">
                    @yield('stylesheet')
                    @yield('content')
                </div>
            </div>
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
    @yield('script')
</body>

</html>