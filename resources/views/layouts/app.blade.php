<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'gurusemua.com') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800|Playfair+Display:400,700,900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/503c3fb5bf.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">

</head>
<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <nav class="nav">
            <div class="container">
                <div class="nav__content">
                    <div class="nav__content__left">
                        <div class="nav-logo">
                            <img src="{{URL::asset('/img/dummy-logo.png')}}">
                        </div>
                        <div class="nav__content-links">
                            <a href="{{ route('landingpage') }}" class="nav--content--link {{ Request::is('/') ? 'active' : '' }}">Beranda
                                <div class="nav--link--decoration"></div>
                            </a>
                            <a href="/mentors" class="nav--content--link {{ Request::is('mentors') ? 'active' : '' }}">Mentor
                                <div class="nav--link--decoration"></div>
                            </a>
                            <a href="{{ route('about-us') }}" class="nav--content--link {{ Request::is('about-us') ? 'active' : '' }}">Tentang Kami
                                <div class="nav--link--decoration"></div>
                            </a>
                            <a href="" class="nav-gone nav--content--link">Bantuan
                                <div class="nav--link--decoration"></div>
                            </a>
                            <div class="search-icon">
                                <img src="{{URL::asset('/img/icon/nav-icon/nav-search.png')}}">
                            </div>
                            <div class="search">
                                <form action="" method="post" class="form-inline">
                                    <div class="input-group">
                                        <input id="searchMain" type="text" class="form-control search-nav" name="search" placeholder="Cari Mentor...">
                                        <div class="input-group-append search-close">
                                            <a href="#"><i class="fas fa-times"></i></a>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn-search" style="display: none;"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="search-result" style="display:none;">
                                    <div class="search-result__lists search-result__mentor">
                                        <span class="color__black_primary">Mentor GuruSemua</span>
                                        <div class="search-result__list">
                                            <div class="search-result__list__result">
                                                <a class="search-result__list__result__link" href="#">
                                                    <img src="{{asset('/img/mentor-img/mentor-image-small.png')}}" alt="">
                                                    <div class="search-result__list__result__text">
                                                        <div class="search-result__list__result__text__title color__black_primary">Fandi Lay</div>
                                                        <div class="search-result__list__result__text__caption color__black_secondary">Designer</div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-result__lists search-result__course d-none">
                                        <span class="colo__black_primary">Kelas GuruSemua</span>
                                        <div class="search-result__list">
                                            <div class="search-result__list__result">
                                                <a class="search-result__list__result__link" href="#">
                                                    <img src="{{asset('/img/mentor-img/mentor-image-small.png')}}" alt="">
                                                    <div class="search-result__list__result__text">
                                                        <div class="search-result__list__result__text__title color__black_primary">Fandi Lay</div>
                                                        <div class="search-result__list__result__text__caption color__black_secondary">Designer</div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav--content--right">
                        @guest
                            <a href="{{ route('login') }}" class="btn--nude">Masuk</a>
                            <a href="{{ route('register') }}" class="btn--medium">Daftar</a>

                        @else

                            <div class="nav-login">
                                <div class="nav-login__icons">
                                    <div class="nav-login__icon">
                                      <a href="{{ route('indexAllPurchases') }}">
                                        <img src="{{URL::asset('/img/icon/nav-icon/nav-cart.png')}}">
                                        <div id="cartCounter" class="nav-login__icon__counter d-none"></div>
                                      </a>
                                    </div>
                                    <div class="nav-login__icon">
                                      <a href="{{ route('wishlists.index') }}">
                                        <img src="{{URL::asset('/img/icon/nav-icon/nav-whislist.png')}}">
                                      </a>
                                    </div>
                                    <div class="nav-login__icon nav-notification">
                                        <a href="{{ route('indexAllNotification') }}" class="nav-notification">
                                            <img src="{{URL::asset('/img/icon/nav-icon/nav-notif.png')}}">
                                            <div id="notificationCounter" class="nav-login__icon__counter">{{ count(auth()->user()->unreadNotifications) }}</div>
                                        </a>
                                        <ul class="nav__dropdown-menu">
                                            @forelse(auth()->user()->unreadnotifications as $notification)
                                                @include("partials.notification.".Str::snake(class_basename($notification->type)))
                                                @empty
                                                    <li class="nav-dropdown__menu">
                                                        <a href="#">No unread Notification</a>
                                                    </li>
                                                    <li class="nav-dropdown__menu text-center font-weight-bold">
                                                        <a href="{{ route('indexAllNotification') }}">View All Notification</a>
                                                    </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                                <div class="nav-login__profile">
                                    <div class="nav-login__avatar">

                                    </div>
                                    <ul class="nav__dropdown-menu">
                                        <li class="nav__user-name">
                                            <a href="{{ route('main.user.profile',Auth::user()->username) }}">
                                                <span>{{ Auth::user()->name }}</span>
                                                <span>{{ Auth::user()->email }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-dropdown__divider"></li>

                                        @hasanyrole('admin')
                                            <li class="nav-dropdown__menu">
                                                <a href="/adm">Admin Page</a>
                                            </li>
                                        @endhasanyrole
                                        <li class="nav-dropdown__menu">
                                            <a href="">Account</a>
                                        </li>
                                        <li class="nav-dropdown__menu">
                                            <a href="">Purchase History</a>
                                        </li>
                                        <li class="nav-dropdown__menu">
                                            <a href="">My Courses</a>
                                        </li>
                                        <li class="nav-dropdown__divider"></li>
                                        <li class="nav-dropdown__menu">
                                            <a href="">Help</a>
                                        </li>
                                        <li class="nav-dropdown__menu">
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>




                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 footer__logo">
                        <img src="{{URL::asset('/img/dummy-logo.png')}}">
                        <p class="body-2">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint.</p>
                    </div>
                    <div class="col-md-2">
                        <span class="footer__title">Menu</span>
                        <ul>
                            <li><a href="">Mentor</a></li>
                            <li class="d-none"><a href="">Semua Akses</a></li>
                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                            <li><a href="">Blog</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <span class="footer__title">Tentang</span>
                        <ul>
                            <li class="d-none"><a href="">Berita</a></li>
                            <li><a href="">Privasi</a></li>
                            <li><a href="">Terms</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <span class="footer__title">Media Sosial</span>
                        <div class="footer__socmed">
                            <a href="#">
                                <div class="footer__socmed__icon"><i class="fab fa-twitter"></i></div>
                            </a>
                            <a href="#">
                                <div class="footer__socmed__icon"><i class="fab fa-instagram"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="copyright">
            Guru Semua {{ date('Y') }} All Right Reserved
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script>
        var debounce;

        $( document ).ready(function() {
            $(".search-icon").on("click",function(){
                $(".search").show();
                $(".nav-gone").css("display","none");
                $(".search-icon").css("display","none");
                $(":input[name=search]").focus();
            });
            $(".search-close").on("click",function(){
                $(".search").hide();
                $(".nav-gone").show();
                $(".search-result").hide();
                $(".search-icon").show();
            });

            $("#searchMain").on('input',debounce(function() {
                $.ajax({
                    url : "{{ route('search.mentor') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        text : this.value
                    },
                    dataType: "json",
                }).done(function(res) {
                    var htmlMentor = "";
                    var htmlLesson = "";
                    const defaultAvatar = "{{asset('/img/mentor-img/mentor-image-small.png')}}";
                    let urlMentor = "{{ url('/mentors/__username__') }}";
                    res.mentor.forEach(function (v , i) {
                        let url = urlMentor.replace("__username__", v.username);

                        console.log(v.img_url);
                        htmlMentor += `<div class="search-result__list__result">
                            <a class="search-result__list__result__link" href="${url}">
                                <img src="${v.img_url}" alt="">
                                <div class="search-result__list__result__text">
                                    <div class="search-result__list__result__text__title color__black_primary">${v.name}</div>
                                    <div class="search-result__list__result__text__caption color__black_secondary">${v.profesi}</div>
                                </div>
                            </a>
                        </div>`;
                    });
                    res.lesson.forEach(function (v,i) {
                        htmlLesson += `<div class="search-result__list__result">
                            <a class="search-result__list__result__link" href="#">
                                <img src="${defaultAvatar}" alt="">
                                <div class="search-result__list__result__text">
                                    <div class="search-result__list__result__text__title color__black_primary">${v.name}</div>
                                    <div class="search-result__list__result__text__caption color__black_secondary">${v.profesi}</div>
                                </div>
                            </a>
                        </div>`;
                    });
                    if (res.mentor.length == 0) {
                        htmlMentor = "No Result";
                    }
                    if (res.lesson.length == 0) {
                        htmlLesson = "No Result";
                    }
                    $(".search-result__mentor > .search-result__list").html(htmlMentor);
                    $(".search-result__course > .search-result__list").html(htmlLesson);
                    $(".search-result").show();
                }).fail(function( jqXHR, textStatus ) {
                }).always(function () {
                });
            }, 400));

            function debounce(callback, delay) {
                var timeout;
                return function() {
                    var args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        callback.apply(this, args)
                    }.bind(this), delay)
                }
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type', 'info') }}";
                var message = "{{ Session::get('message') }}";
                showToast(type,message);
            @endif
        });
        function showToast(type, message) {
            switch(type){
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }
        }
    </script>
    @yield('script')
</body>
</html>
