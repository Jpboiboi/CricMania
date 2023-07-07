@extends('frontend.layouts.app')
@section('main-content')
@push('styles')
    <style>
        body{
            /* background: #f4faff; */
            background: #fafafa;
        }
    </style>

@endpush
   @php
        $teamCount=$teams->count();
        $count=$teams->count()+1;
        $teamsCount=$teams->count()-1;
        $teamCount=intval(round($teamCount/2,0,PHP_ROUND_HALF_UP));
   @endphp
    <div class="container">
        <h1>Scheduling tournament : {{$tournament->name}}</h1>
        <h4 class="ms-3 text-muted">~ Organized by: {{$tournament->organizer->name}}</h4>
        <hr>
            <h2>STAGE 1</h2>
            <?php
                $j=0;
                $k=1;
            ?>
            <div class="row d-flex justify-content-center">
        @for($i=1;$i<=$teamCount;$i++)

                <div class="col-md-6">
                    <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                        <div class="card-body ribbon-corner">
                            <div class="d-flex justify-content-center">
                                <div class="team-1">
                                    <img src="{{asset($teams[$j]->team1->image_path)}}" alt="{{$teams[$j]->team1->name}}" width="100px" height="100px" class="object-fit-contain border rounded mb-2">
                                    <h5 class="ms-4">{{$teams[$j]->team1->name}}</h5>
                                </div>
                                <span class="m-5"><h3>vs</h3></span>
                                <div class="team-2">
                                    <img src="{{asset($teams[$j]->team2->image_path)}}" alt="" width="100px" height="100px" class="object-fit-contain border rounded mb-2" >
                                    <h5 class="ms-2">{{$teams[$j]->team2->name}}</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="text-muted mt-3">Match {{$k}}</p>
                                @if ($teams[$j]->is_live)
                                <p><i class="fa fa-check-circle-o text-success mt-4" aria-hidden="true"> Live</i></p>
                                @else
                                    <div>
                                        <i class="fa fa-clock-o text-danger mt-4" aria-hidden="true"></i>
                                        <p class="d-inline text-danger">Yet to be started</p>
                                    </div>
                                 @endif
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Scheduled on: {{ date("d-m-Y", strtotime($teams[$j]->match_date))}}</p>
                                @if ($teams[$j]->is_live)
                                <button class="btn btn-warning">Begin Scoring</button>
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
                                            <h5 class="ms-4">{{$teams[$teamsCount]->team1->name}}</h5>
                                        </div>
                                        <span class="m-5"><h3>vs</h3></span>
                                        <div class="team-2">
                                            <img src="{{asset('assets/img/TBD.png')}}" alt="" width="100px" height="100px" class="object-fit-contain mb-2" >
                                            <h5 class="ms-4">{{$teams[$teamsCount]->team2->name}}</h5>
                                        </div>
                                    </div>
                                    <p class="text-muted">Match {{$k}}</p>
                                    <p>Scheduled on: {{date('d-m-Y', strtotime($teams[$j]->match_date))}}</p>

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
                                    <h5 class="ms-4">{{$teams[$teamsCount]->team1->name}}</h5>
                                </div>
                                <span class="m-5"><h3>vs</h3></span>
                                <div class="team-2">
                                    <img src="{{asset('assets/img/TBD.png')}}" alt="" width="100px" height="100px" class="object-fit-contain mb-2" >
                                    <h5 class="ms-4">{{$teams[$teamsCount]->team2->name}}</h5>
                                </div>
                            </div>
                            <p class="text-muted">Match {{$k}}</p>
                            <p>Scheduled on:{{date('d-m-Y', strtotime($teams[$j]->match_date))}}</p>
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
                                    <h5 class="ms-4">{{$teams[$teamsCount]->team1->name}}</h5>
                                </div>
                                <span class="m-5"><h3>vs</h3></span>
                                <div class="team-2">
                                    <img src="{{asset('assets/img/TBD.png')}}" alt="" width="100px" height="100px" class="object-fit-contain mb-2" >
                                    <h5>{{$teams[$teamsCount]->team2->name}}</h5>
                                </div>
                            </div>
                            <p class="text-muted">Match {{$k}}</p>
                            <p>Scheduled on:{{date('d-m-Y', strtotime($teams[$j]->match_date))}}</p>
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
