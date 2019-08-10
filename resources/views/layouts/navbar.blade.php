<nav class="navbar navbar-expand-md navbar-dark navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/DV-Logo3-icon.png') }}" width="40">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Route::currentRouteNamed('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>

                <li class="nav-item">
                    <div class="dropdown">
                        <a class="btn btn-outline-secondary text-white dropdown-toggle {{ Route::currentRouteNamed('events.*') || Route::currentRouteNamed('bookings.*') ? 'active' : '' }}"
                           href="#" role="button" id="dropdownEvents" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false">
                            Events
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownEvents">
                            @foreach(nextEvents() as $event)
                                <a class="dropdown-item {{ url()->current() == route('events.show', $event) || url()->current() == route('bookings.event.index', $event) ? 'active' : '' }}"
                                   href="{{ route('events.show', $event) }}">{{ $event->name }}
                                    – {{ $event->startEvent->toFormattedDateString() }}</a>
                                @auth
                                    @foreach($bookings = Auth::user()->bookings()->where('event_id', $event->id)->get() as $booking)
                                        <a class="dropdown-item {{ url()->current() == route('bookings.show', $booking) ? 'active' : '' }}"
                                           href="{{ route('bookings.show', $booking) }}">
                                            <i class="fas fa-arrow-right"></i>&nbsp;{{ $bookings->count() > 1 ? $booking->callsign : 'My booking' }}
                                        </a>
                                    @endforeach
                                @endauth
                                @if(!$loop->last)
                                    <div class="dropdown-divider"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>

                <li class="nav-item {{ Route::currentRouteNamed('faq') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('faq') }}">FAQ</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="mailto:events@dutchvacc.nl">Contact Us</a>
                </li>
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>

                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="btn btn-outline-secondary text-white dropdown-toggle {{ Request::is('admin/*') || Request::is('user/*') ? 'active' : '' }}"
                               href="#" role="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                {{ Auth::user()->pic }}
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownUser">
                                <a class="dropdown-item {{ Route::currentRouteNamed('user.settings') ? 'active' : '' }}"
                                   href="{{ route('user.settings') }}">My settings</a>
                                @if(Auth::user()->isAdmin)
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item {{ Route::currentRouteNamed('airports.*') ? 'active' : '' }}"
                                       href="{{ route('airports.index') }}">Airports</a>
                                    <a class="dropdown-item {{ Route::currentRouteNamed('events.*') ? 'active' : '' }}"
                                       href="{{ route('events.index') }}">Events</a>
                                    <a class="dropdown-item {{ Route::currentRouteNamed('faq.*') ? 'active' : '' }}"
                                       href="{{ route('faq.index') }}">FAQ</a>
                                @endif
                            </div>
                        </div>
                    </li>
                @endguest
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><img src="{{ asset('images/DV-Logo3.png') }}" width="200"></li>
            </ul>

        </div>
    </div>
</nav>
