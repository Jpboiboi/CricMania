<header id="header" class="sticky-top bg-black">
    <div class="container d-flex align-items-center justify-content-lg-between ">
      <h1 class="logo me-auto me-lg-0"><a href="index.html">C<span>M</span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>

          <li><a class="{{Route::currentRouteName()==='frontend.index' ? 'active':""}}" href="{{route('frontend.index')}}">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="nav-link {{ Route::currentRouteName() === 'registration' ? 'active' : ''  }}" href="{{route('registration')}}">Register as player</a></li>
          @auth
            <li><a class="nav-link {{Route::currentRouteName()==='tournaments.index' ? 'active':""}}" href="{{route('tournaments.index')}}">My Tournaments</a></li>
          @endauth
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->


        @if (auth()->check())
                {{-- <a href="" class=" dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> {{auth()->user()->name}}
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                  </ul>
                </a> --}}
                <div class="btn-group">
                  <button type="button" class="btn bg-warning dropdown-toggle fa fa-user" data-bs-toggle="dropdown" aria-expanded="false">
                    {{auth()->user()->name}}
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                                <button type="submit" class="btn">Logout</button>
                        </form>
                    </li>
                  </ul>
                </div>


                @else
                <a href="{{route('login')}}" class="get-started-btn scrollto">Login</a>
        @endif


    </div>
  </header>
