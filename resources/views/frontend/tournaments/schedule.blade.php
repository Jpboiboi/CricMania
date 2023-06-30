@extends('frontend.layouts.app')

@section('main-content')

   @php
        $teamCount=$teams->count();
        if($teamCount === 3 || $teamCount === 7 || $teamCount === 9){
            $teamCount = round(($teamCount/2),0,PHP_ROUND_HALF_UP);
        }
        else {
            $teamCount=$teamCount/2;
        }

        $teamsCount=$teams->count()-1;
        // dd($teamsCount);
   @endphp
    <div class="container">
        <h2>Scheduling tournament : {{$tournament->name}}</h2>
        <h4 class="ms-3 text-muted">~ Organized by: {{$tournament->organizer->name}}</h4>
        <hr>
            <h1>STAGE 1</h1>
            <?php
                $j=0;
                $k=1;
            ?>
            @for($i=1;$i<=$teamCount;$i++)

            <div class="card mb-3 border border-black">
                <div class="card-body">
                    <h5>{{$teams[$j]->team1->name}} vs {{$teams[$j]->team2->name}} </h5>
                    <p class="text-muted">Match {{$k}}</p>
                    <p>Scheduled on: {{ date("d-m-Y", strtotime($teams[$j]->match_date))}}</p>
                    <?php
                    $j++;
                    $k++;
                    ?>
                </div>
            </div>
            @endfor
            @php
                // $j=0;
                if($teamCount == 3 || $teamCount == 5){
                    $teamCount=round($teamCount/2,0,PHP_ROUND_HALF_UP);
                }else{
                    $teamCount=round($teamCount/2,0,PHP_ROUND_HALF_DOWN);
                }

            @endphp
            <hr>
            <h1>STAGE 2</h1>
            @for($i=1;$i<=$teamCount;$i++)

            <div class="card mb-3 border border-black">
                <div class="card-body">
                    <h5>{{$teams[$teamsCount]->team1->name}} vs {{$teams[$teamsCount]->team2->name}}</h5>
                    <p class="text-muted">Match {{$k}}</p>
                    <p>Scheduled on: {{date('d-m-Y', strtotime($teams[$j]->match_date))}}</p>
                    <?php
                    $j++;
                    $k++;
                    // $tbd++;

                    ?>
                </div>
            </div>
            @endfor
            @php
                if($teamCount === 3.0){
                    $teamCount = round(($teamCount/2),0,PHP_ROUND_HALF_UP);
                }
                else {
                    $teamCount = $teamCount/2;
                }

            @endphp

            <hr>
            @if ($teamCount > 0.5)
            <h1>STAGE 3</h1>
            @for($i=1;$i<=$teamCount;$i++)
                <div class="card mb-3 border border-black">
                <div class="card-body">
                    <h5>{{$teams[$teamsCount]->team1->name}} vs {{$teams[$teamsCount]->team2->name}}</h5>
                    <p class="text-muted">Match {{$k}}</p>
                    <p>Scheduled on:{{date('d-m-Y', strtotime($teams[$j]->match_date))}}</p>
                    <p></p>
                    <?php
                    $j++;
                    $k++;
                    ?>
                </div>
            </div>
            @endfor
            @php
                $teamCount=$teamCount/2;
            @endphp
            <hr>
            @if ($teamCount > 0.5)
            <h1>STAGE 4</h1>
            @for($i=1;$i<=$teamCount;$i++)
                <div class="card mb-3 border border-black">
                <div class="card-body">
                    <h5>{{$teams[$j]->team1->name}} vs {{$teams[$j]->team2->name}}</h5>
                    <p class="text-muted">Match {{$k}}</p>
                    <p>Scheduled on:{{date('d-m-Y', strtotime($teams[$j]->match_date))}}</p>
                    <p></p>
                    <?php
                    $j++;
                    $k++;
                    ?>
                </div>
            </div>
            @endfor
            @endif
         </div>
         @endif


        </div>

@endsection
