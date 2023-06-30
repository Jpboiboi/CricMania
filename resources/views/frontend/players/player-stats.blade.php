@push('styles')
    <style>
        .table-black{
        --bs-border-color: #000000;
        }
        .custom-bg{
            background: #1E263D;
        }
        body{
            font-family: 'Poppins';
            background: #f4faff;
        }
        h1, h2, h3, h4, h5, h6 {
        font-family: "Poppins";
        }
        .font-large{
            font-size: 3rem;
        }
        .font-larger{
            font-size: 3.3rem;
        }

    </style>

@endpush

@extends('frontend.layouts.app')
@section('main-content')
<div class="container-fluid pb-1">
    <div class="container">
        <h1 class="mb-5 text-uppercase font-larger">Player Stats</h1>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center ">
                @isset($user->photo_path)
                <img src=" {{asset('/storage/'.$user->photo_path)}}" class="rounded-circle bg-light border border-dark border-4" alt="" width="250px">
                @else
                <img src="{{ asset('assets/img/player-avatar.png') }}" class="rounded-circle bg-light border border-dark border-4" alt="" width="250px">
            @endisset
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <h2 > {{ $user->first_name }} {{ $user->last_name }}</h2>
            </div>
        </div>
        <hr>
            @foreach ($playerStats as $playerStat)
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    @if ($playerStat->no_of_matches > 0)
                        <h2 class="mt-3 text-uppercase mb-3 font-large">{{ $playerStat->tournament_type->name }}</h2>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <h3 class="font-1">Player overview</h3>
                </div>
            </div>
            <div class="row table-black">
                <div class="col-md-12 d-flex justify-content-center">
                    <div>
                        <div class="row row-cols-2 ">
                            <div class="col border bg-light">
                                <p class="fs-5 fw-bold pt-1">{{ $playerStat->no_of_matches }}</p>
                                <p >Matches</p>
                            </div>
                          <div class="col border bg-light">
                                    <p class="fs-5 fw-bold">{{ $playerStat->player->fav_playing_spot}} </p>
                                <p>Playing Spot</p>
                            </div>
                            <div class="col border bg-light">
                                <p class="fs-5  fw-bold pt-1">{{ $playerStat->player->balling_hand }}</p>
                                <p>Balling Hand</p>
                            </div>
                            <div class="col border bg-light">
                                <p class="fs-5  fw-bold pt-1">{{ $playerStat->player->batting_hand }}</p>
                                <p>Batting Hand</p>
                            </div>
                    </div>

                    </div>
                </div>
            </div>

            <h2 class="mt-3 font-1 text-uppercase">Batting Stats</h2>
        <table class="table table-bordered table-responsive table-black custom-bg border-3">
            <thead>
                <th>Innings</th>
                <th>NO</th>
                <th>Runs</th>
                <th>Avg</th>
                <th>SR</th>
                <th>100</th>
                <th>50</th>
                <th>4s</th>
                <th>6s</th>
                <th>Balls</th>


            </thead>
            <tbody>
                <tr class="table-black">
                    <td>{{ $playerStat->no_of_innings }}</td>
                    <td>{{ $playerStat->no_of_innings - $playerStat->player_out }} </td>
                    <td>{{ $playerStat->no_of_runs_scored }}</td>
                    <td>{{ $playerStat->player_avg }}</td>
                    <td>{{$playerStat->player_sr}}</td>
                    <td>{{ $playerStat->no_of_hundreds }}</td>
                    <td>{{ $playerStat->no_of_fifties }}</td>
                    <td>{{ $playerStat->no_of_fours }}</td>
                    <td>{{ $playerStat->no_of_sixes }}</td>
                    <td>{{ $playerStat->no_of_balls_faced }}</td>

                </tr>
            </tbody>

        </table>
        <h2 class="mt-3 text-uppercase">Balling Stats</h2>
        <table class="table-bordered table table-responsive table-black">
            <thead>
                <th>Innings</th>
                <th>Balls</th>
                <th>Runs</th>
                <th>Wkts</th>
                <th>Avg</th>
                <th>Eco</th>
                <th>SR</th>
                <th>4W</th>
                <th>5W</th>
                <th>Hattricks</th>
                <th>Maidens</th>
                <th>Wides</th>
                <th>No balls</th>


            </thead>
            <tbody>
                <tr>
                    <td>{{ $playerStat->no_of_innings }}</td>
                    <td>{{ $playerStat->no_of_balls_bowled }} </td>
                    <td>{{ $playerStat->no_of_runs_conceeded}}</td>
                    <td>{{ $playerStat->no_of_wickets_taken }}</td>
                    <td>{{ $playerStat->balling_avg  }}</td>
                    <td>{{ $playerStat->balling_eco }}</td>
                    <td>{{ $playerStat->balling_sr }}</td>
                    <td>{{ $playerStat->four_wicket_hauls }}</td>
                    <td>{{ $playerStat->five_wicket_hauls }}</td>
                    <td>{{ $playerStat->hattricks }}</td>
                    <td>{{ $playerStat->no_of_maidens }}</td>
                    <td>{{$playerStat->wides}}</td>
                    <td>{{$playerStat->no_balls}}</td>

                </tr>
            </tbody>

        </table>
        <hr class="my-4"
            style="border:3px solid rgb(0, 0, 0)"
        >
        @endforeach
     </div>
        </div>
    </div>
</div>
@endsection
