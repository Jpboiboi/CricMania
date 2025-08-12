@extends('frontend.layouts.app')
@section('main-content')
@push('styles')
    <style>
        body{
            /* background: #f4faff; */
            background: #fafafa;
        }
        .card .card_container{
            padding : 2rem;
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 1rem;
            position: relative;
        }

        .ribbon.card::before{
            position: absolute;
            top:40px;
            right:-0.5rem;
            content: '';
            /* background: #283593; */
            background: rgba(var(--bs-success-rgb),var(--bs-bg-opacity))!important;
            height: 28px;
            width: 28px;
            transform : rotate(45deg);
        }

        .ribbon.card::after{
            position: absolute;
            /* content: attr(data-label); */
            content: "\2713 \a0 \a0 Live";
            top: 15px;
            right: -14px;
            padding: 0.5rem;
            width: 8rem;
            height: 40px;
            /* background: #3949ab; */
            background: rgba(var(--bs-success-rgb),var(--bs-bg-opacity))!important;
            color: white;
            text-align: center;
            font-family: 'Roboto', sans-serif;
            box-shadow: 4px 4px 15px rgba(26, 35, 126, 0.2);
        }
    </style>

@endpush
   @php
        $teamCount=$tournamentMatches->count();
        $count=$tournamentMatches->count()+1;
        $tournamentMatchesCount=$tournamentMatches->count()-1;
        $teamCount=intval(round($teamCount/2,0,PHP_ROUND_HALF_UP));
   @endphp
    <div class="container">
        <h1 class="mt-4">Scheduled tournament : {{$tournament->name}}</h1>
        <h4 class="ms-3 text-muted">~ Organized by: {{$tournament->organizer->first_name . ' ' . $tournament->organizer->last_name}}</h4>
        <h4 >Tournament type:
            @if ($tournament->is_single_day)
                Single Day
            @else
                Multi Days
            @endif
        </h4>
        <hr>
            <h2>STAGE 1</h2>
            <?php
                $j=0;
                $k=1;
            ?>
            <div class="row d-flex justify-content-center">
        @for($i=1;$i<=$teamCount;$i++)

                <div class="col-md-6">
                    <div class="card shadow mb-5 bg-white rounded @if ($tournamentMatches[$j]->is_live) ribbon @endif"> {{-- @if ($tournamentMatches[$j]->is_live) data-label=" Live" @endif --}}
                        <div class="card_container">
                            <div class="card-body ribbon-corner">
                                <div class="d-flex justify-content-center">
                                    <div class="team-1">
                                        <img src="{{asset($tournamentMatches[$j]->team1->image_path)}}" alt="{{$tournamentMatches[$j]->team1->name}}" width="100px" height="100px" class="object-fit-contain border rounded mb-2">
                                        <h5 class="ms-4">{{$tournamentMatches[$j]->team1->name}}</h5>
                                    </div>
                                    <span class="m-5"><h3>vs</h3></span>
                                    <div class="team-2">
                                        <img src="{{asset($tournamentMatches[$j]->team2->image_path)}}" alt="" width="100px" height="100px" class="object-fit-contain border rounded mb-2" >
                                        <h5 class="ms-2">{{$tournamentMatches[$j]->team2->name}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p class="text-muted mt-3">Match {{$k}}</p>
                                    @if ($tournamentMatches[$j]->is_live)
                                    {{-- <p><i class="fa fa-check-circle-o text-success mt-4" aria-hidden="true"> Live</i></p> --}}
                                    @else
                                        <div>
                                            <i class="fa fa-clock-o text-danger mt-4" aria-hidden="true"></i>
                                            <p class="d-inline text-danger">Yet to be started</p>
                                        </div>
                                     @endif
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Scheduled on: {{ date("d-m-Y", strtotime($tournamentMatches[$j]->match_date))}}</p>
                                    @if ($tournamentMatches[$j]->is_live)

                                        <a href="{{route('scoring',[$tournament->id,$tournamentMatches[$j]->id])}}" class="btn btn-warning">Begin Scoring</a>


                                    @else
                                        <button class="btn btn-secondary" disabled>Begin Scoring</button>
                                     @endif
                                </div>

                                <?php
                                    $j++;
                                    $k++;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>



            @endfor
        </div>
            @php

                    $teamCount=intval(round($teamCount/2,0,PHP_ROUND_HALF_DOWN));

            @endphp
            <hr>

            <h2>STAGE 2</h2>
            <div class="row d-flex justify-content-center">
            @for($i=1;$i<=$teamCount;$i++)

                        <div class="col-md-6">
                            <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center">
                                        <div class="team-1">
                                            <img src="{{asset('assets/img/TBD.png')}}" alt="TBD" width="100px" height="100px" class="object-fit-contain mb-2">
                                            <h5 class="ms-4">{{$tournamentMatches[$tournamentMatchesCount]->team1->name}}</h5>
                                        </div>
                                        <span class="m-5"><h3>vs</h3></span>
                                        <div class="team-2">
                                            <img src="{{asset('assets/img/TBD.png')}}" alt="" width="100px" height="100px" class="object-fit-contain mb-2" >
                                            <h5 class="ms-4">{{$tournamentMatches[$tournamentMatchesCount]->team2->name}}</h5>
                                        </div>
                                    </div>
                                    <p class="text-muted">Match {{$k}}</p>
                                    <p>Scheduled on: {{date('d-m-Y', strtotime($tournamentMatches[$j]->match_date))}}</p>

                                    <?php
                                        $j++;
                                        $k++;
                                    ?>
                                </div>
                            </div>
                        </div>

            @endfor
        </div>
            @php
                if($count === 6 || $count ===10 ){
                    $teamCount = intval(round(($teamCount/2),0,PHP_ROUND_HALF_UP));
                }
                else {
                    $teamCount = intval(round(($teamCount/2),0,PHP_ROUND_HALF_DOWN));
                }
            @endphp
            <hr>

            @if ($teamCount > 0)
            <h2>STAGE 3</h2>
            <div class="row d-flex justify-content-center">
            @for($i=1;$i<=$teamCount;$i++)

                <div class="col-md-6">
                    <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="team-1">
                                    <img src="{{asset('assets/img/TBD.png')}}" alt="TBD" width="100px" height="100px" class="object-fit-contain mb-2">
                                    <h5 class="ms-4">{{$tournamentMatches[$tournamentMatchesCount]->team1->name}}</h5>
                                </div>
                                <span class="m-5"><h3>vs</h3></span>
                                <div class="team-2">
                                    <img src="{{asset('assets/img/TBD.png')}}" alt="" width="100px" height="100px" class="object-fit-contain mb-2" >
                                    <h5 class="ms-4">{{$tournamentMatches[$tournamentMatchesCount]->team2->name}}</h5>
                                </div>
                            </div>
                            <p class="text-muted">Match {{$k}}</p>
                            <p>Scheduled on:{{date('d-m-Y', strtotime($tournamentMatches[$j]->match_date))}}</p>
                            <p></p>
                            <?php
                            $j++;
                            $k++;
                            ?>
                        </div>
                    </div>
                </div>

            @endfor
        </div>
            @php
                 if($count ===10 ){
                    $teamCount = intval(round(($teamCount/2),0,PHP_ROUND_HALF_UP));
                }
                else {
                    $teamCount = intval(round(($teamCount/2),0,PHP_ROUND_HALF_DOWN));
                }
            @endphp
            <hr>
            @if ($teamCount > 0)
            <h2>STAGE 4</h2>
            <div class="row d-flex justify-content-center">
            @for($i=1;$i<=$teamCount;$i++)
                <div class="col-md-6">
                    <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="team-1">
                                    <img src="{{asset('assets/img/TBD.png')}}" alt="TBD" width="100px" height="100px" class="object-fit-contain mb-2">
                                    <h5 class="ms-4">{{$tournamentMatches[$tournamentMatchesCount]->team1->name}}</h5>
                                </div>
                                <span class="m-5"><h3>vs</h3></span>
                                <div class="team-2">
                                    <img src="{{asset('assets/img/TBD.png')}}" alt="" width="100px" height="100px" class="object-fit-contain mb-2" >
                                    <h5>{{$tournamentMatches[$tournamentMatchesCount]->team2->name}}</h5>
                                </div>
                            </div>
                            <p class="text-muted">Match {{$k}}</p>
                            <p>Scheduled on:{{date('d-m-Y', strtotime($tournamentMatches[$j]->match_date))}}</p>
                            <p></p>
                            <?php
                            $j++;
                            $k++;
                            ?>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
            @endif
         </div>
         @endif


        </div>

@endsection
