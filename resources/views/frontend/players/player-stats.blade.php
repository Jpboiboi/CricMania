@extends('frontend.layouts.app')
@section('main-content')
<div class="container-fluid bg-dark pb-1">
    <div class="container bg-dark text-warning">
        <h1 class="mb-5 font-1 text-decoration-underline">Player Stats</h1>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center ">
                @isset($playerStats->first()->player->photo_path)
                <img src="{{$playerStats->first()->player->photo_path}}" alt="">
            @else
                <img src="{{ asset('assets/img/player-avatar.png') }}" class="rounded-circle bg-light" alt="" width="200px">
            @endisset
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <h2 class="text-light"> {{ $playerStats->first()->player->first_name }} {{ $playerStats->first()->player->last_name }}</h2>
            </div>
        </div>

            @foreach ($playerStats as $playerStat)
            <h2 class="mt-3 text-decoration-underline">{{ $playerStat->tournament_type->name }} stats</h2>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <h3 class="font-1">Player overview</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="row row-cols-2">
                        <div class="col border">
                            <p class="fs-5 text-light fw-bold pt-1">{{ $playerStat->no_of_matches }}</p>
                            <p class="text-light">Matches</p>
                        </div>
                      <div class="col border">
                                <p class="fs-5 text-light fw-bold">{{ $playerStat->player->fav_playing_spot}} </p>
                            <p class="text-light">Playing Spot</p>
                        </div>
                        <div class="col border">
                            <p class="fs-5 text-light fw-bold pt-1">{{ $playerStat->player->balling_hand }}</p>
                            <p class="text-light">Balling Hand</p>
                        </div>
                        <div class="col border">
                            <p class="fs-5 text-light fw-bold pt-1">{{ $playerStat->player->batting_hand }}</p>
                            <p class="text-light">Batting Hand</p>
                        </div>

                    </div>
                </div>
            </div>
            <h2 class="mt-3 font-1">Batting Stats</h2>
        <table class="table table-bordered table-responsive">
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
                <tr>
                    <td>{{ $playerStat->no_of_innings }}</td>
                    <td>{{ $playerStat->no_of_innings - $playerStat->player_out }} </td>
                    <td>{{ $playerStat->no_of_runs_scored }}</td>
                    <td>{{ round($playerStat->no_of_innings / $playerStat->player_out,2) }}</td>
                    <td>{{ round(($playerStat->no_of_runs_scored / $playerStat->no_of_balls_faced) * 100 ,2)}}</td>
                    <td>{{ $playerStat->no_of_hundreds }}</td>
                    <td>{{ $playerStat->no_of_fifties }}</td>
                    <td>{{ $playerStat->no_of_fours }}</td>
                    <td>{{ $playerStat->no_of_sixes }}</td>
                    <td>{{ $playerStat->no_of_balls_faced }}</td>

                </tr>
            </tbody>

        </table>
        <h2 class="mt-3 font-1">Balling Stats</h2>
        <table class="table-bordered table-responsive table ">
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
                    <td>{{ round($playerStat->no_of_runs_conceeded / $playerStat->no_of_wickets_taken,2)  }}</td>
                    <td>{{ $playerStat->no_of_runs_conceeded / ($playerStat->no_of_runs_conceeded)*6 }}</td>
                    <td>{{ round(($playerStat->no_of_balls_bowled / $playerStat->no_of_wickets_taken )*100,2) }}</td>
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
            style="border:3px solid white"
        >
    @endforeach
     </div>
        </div>
    </div>
</div>
@endsection
