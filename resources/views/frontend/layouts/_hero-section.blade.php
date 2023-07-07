<section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">

      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-6 col-lg-8">
          <h1>Cric<span>Mania</span></h1>
          <h2>Cricket happens to be an unpredictable game which makes it so interesting.</h2>
        </div>
      </div>

      <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
        <div class="col-xl-2 col-md-4">
        <a href="{{ route('tournaments.create') }}">
          <div class="icon-box">
             <i class="ri-team-fill"></i>
            <h3>Organizer</h3>
          </div>
        </a>

        </div>
        <div class="col-xl-2 col-md-4">
        <a href="{{ route('scorer.create') }}">
            <div class="icon-box">
            <i class="ri-bar-chart-box-line fa fa-bat"></i>
            <h3>Scorer</h3>
            {{-- <p>Scorer</p> --}}
          </div>
        </a>
        </div>
        <div class="col-xl-2 col-md-4">
        <a href="{{route('players.index')}}">
          <div class="icon-box">
            <i><span class="material-symbols-outlined">
                sports_cricket
                </span></i>
            <h3>Players</h3>

          </div>
        </a>
        </div>
      </div>

    </div>
  </section>
