<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="PIXINVENT">
    @yield('title')
    {{-- <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png')}}"> --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.png') }}">
    @include('layout.css.css')
    @yield('css')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="">
    @include('layout.header')
    @include('layout.sidebar')


    <div class="overlay">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>

    {{-- content divs --}}

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper" style="margin-top: -40px;">
            <div class="content-header row">
            </div>

            {{-- back btn --}}
            @if(View::hasSection('main_btn_href'))
                <div class="main_back_btn mb-2 mt-1"><a href="@yield('main_btn_href')" style="letter-spacing: 1px;"><i data-feather='chevron-left'></i> @yield('main_btn_text')</a> </div>
            @endif

            <div class="content-body">

                {{-- @if(!(Request::is('/')))
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard </a>
                            <i data-feather="chevrons-right"></i>
                            </li>
                            {{count(Request::segments())}}
                            @for($i = 0; $i <= count(Request::segments()); $i++)

                                @if($i!=count(Request::segments()))
                                    <li>
                                    <a href="{{ url()->previous()}}" >{{Request::segment($i)}}</a>
                                    @if($i < count(Request::segments()) & $i > 0)
                                        {!!'<i data-feather="chevrons-right"></i>'!!}
                                    @endif
                                    </li>
                                @else
                                <li>

                                    @if( (strpos(url()->current(),'edit')) > 0 )

                                        <a href="{{ url()->current() }}">
                                            Edit
                                        </a>

                                    @elseif( strlen(url()->current() ) == 220)

                                        <a href="{{ url()->current() }}" >
                                            View
                                        </a>
                                    @else

                                        <a href="{{ url()->current() }}" >{{Request::segment($i)}}</a>
                                    @endif


                                    @if($i < count(Request::segments()) & $i > 0)
                                        {!!'<i data-feather="chevrons-right"></i>'!!}
                                    @endif
                                    </li>
                                @endif
                            @endfor

                        </ol>
                    </div>
                @endif --}}

                @yield('content')
            </div>
        </div>
    </div>



    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('layout.footer')
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>

    @include('layout.js.js')
    @yield('scripts')
</body>
</html>

@yield('modal')
