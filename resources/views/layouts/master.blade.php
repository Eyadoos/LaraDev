<!DOCTYPE html>
<html>
	<head>
		<title>Lara | @yield('title', 'Default Title')</title>
        <meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <meta http-equiv="Cache-control" content="no-cache">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @if( \Lara\utilities\ViewUtility::isLightMode())
        <link rel="stylesheet" type="text/css" href="{{ asset(WebpackBuiltFiles::$cssFiles['lara']) }}">
        @else
        <link rel="stylesheet" type="text/css" href="{{ asset(WebpackBuiltFiles::$cssFiles['darkmode']) }}">
        @endif
        {{--
        <link rel="stylesheet" type="text/css" href="{{ mix('/static.css') }}">
        --}}
        @if (App::environment('development'))
            <link rel="shortcut icon" type="image/png" href="{{ asset('/favicon-demo-48x48.png') }}">
        @elseif (App::environment('berta'))
            <link rel="shortcut icon" type="image/png" href="{{ asset('/favicon-berta-48x48.png') }}">
        @else
    	<link rel="shortcut icon" type="image/png" href="{{ asset('/favicon-48x48.png') }}">
        @endif

        @yield('moreStylesheets')
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="{{asset(WebpackBuiltFiles::$jsFiles['legacy'])}}" ></script>
        <![endif]-->
        @php($clubId = '')
        @php($personId = '')
        @php($generalNotifications = 0)

        @auth
            @php($clubId =  Auth::user()->person->clb_id )
            @php($personId =  Auth::user()->person->id )
            @php($generalNotifications =  Auth::user()->person->generalNotifications ? '1' : '0' )
        @endauth

        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
        var OneSignal = window.OneSignal || [];
        let userLoggedIn = '{{ Auth::id() }}'
        if (userLoggedIn) {
            let personId = '{{ $personId }}';
            let userClubId = '{{ $clubId }}';
            let generalNotifications = '{{ $generalNotifications }}';
            OneSignal.push(function () {
                OneSignal.init({
                    appId: "6b078023-5746-4a90-b0b5-21786320952b",
                });
                OneSignal.sendTag("generalNotifications",generalNotifications);
            });
            OneSignal.push(function() {
                OneSignal.on('subscriptionChange', function(isSubscribed) {
                    if (isSubscribed) {
                        OneSignal.push(function() {
                            OneSignal.setExternalUserId(personId);
                            OneSignal.sendTag("Segment",userClubId);
                            OneSignal.sendTag("generalNotifications",generalNotifications);
                        });
                    }
                });
            });
        }

    </script>
	</head>

    <body @if(Session::get("language","de")  == "pirate")
              style="background-image:url( {{asset('/background-pirate.jpg')}} ) !important;
                     background-size:initial;
                     background-position:center;"
          @endif>

        <!-- Set the language to the same as the server -->
        <script type="text/javascript">
            localStorage.setItem('language', "{{ Session::get("language","de") }}");
        </script>

		<header class="navigation">
			@include('partials.navigation')
		</header>

		<div class="message" id="centerpoint">
			@include('partials.message')
		</div>

        <section class="container-fluid px-0">
            @yield('content')
        </section>

        <!-- Back to Top button -->
        <a id="back-to-top"
           href="#"
           class="btn btn-primary btn-lg back-to-top hidden-print d-md-none d-lg-none d-sm-block d-block"
           role="button"
           title="{{ trans("mainLang.backToTop")  }}"
           data-toggle="tooltip"
           data-placement="right">
            <i class="fas fa-chevron-up"></i>
        </a>

        <br>

     	<section class="footer">
            @include('partials.footer')
        </section>

        <script> var enviroment = '{{App::environment()}}'; </script>
        <script src="{{asset(WebpackBuiltFiles::$jsFiles['lara'])}}" ></script>
        @yield('moreScripts')
        {{--
            <script src="{{ mix('/manifest.js') }}"></script>
            <script src="{{ mix('/vendor.js') }}"></script>
            <script src="{{ mix('/static.js') }}"></script>
            <script src="{{ mix('/lara.js') }}"></script>
        --}}
    </body>
</html>
