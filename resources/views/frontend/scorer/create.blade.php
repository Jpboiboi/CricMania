@extends('frontend.layouts.app')

@push('styles')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

  <link rel="stylesheet" href="{{asset('assets/css/stepper.css')}}">
  <style>
    .object-fit{
        object-fit: cover;
    }

  </style>

  @endpush

@section('main-content')
<div class="container height">
    <input type="hidden" name="inning" id="inning" value="{{ $inning }}">
    <!-- MultiStep Form -->
<div class="row d-flex justify-content-center">
        <div class="col-md-8 height">
            <div id="mainSection">
                <!-- progressbar -->
                <div class="progressbar justify-content-center">
                    <ul id="progressbar">
                        <li class="active">Toss & Elect</li>
                        <li>Select Playing XI</li>
                        <li>Select C,Vc And Wk</li>
                        <li>Start Innings</li>
                    </ul>
                </div>
                <!-- fieldsets -->
                <div class="screens">
                    <span id="loader"></span>
                    <fieldset>
                        <h2 class="fs-title">Toss</h2>
                        <h3 class="fs-subtitle">Who won the toss?</h3>
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start" >
                                <div class="card mt-3 mb-3" id="updateTossTeam1" data-toss="{{$tournamentMatch->team1->id}}" style="width: 7rem;">
                                    <div class="card-body btn toss-team1">
                                        <h5 class="card-title mt-2">{{$tournamentMatch->team1->name}}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="card mt-3 mb-3" id="updateTossTeam2" data-toss="{{$tournamentMatch->team2->id}}" style="width: 7rem;">
                                    <div class="card-body btn toss-team2">
                                        <h5 class="card-title mt-2">{{$tournamentMatch->team2->name}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3 class="fs-subtitle">Winner of the toss elected to?</h3>

                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start" >
                                <div class="card mt-3 mb-3" id="updateElectedToBat" data-elected_to="bat" style="width: 7rem;">
                                    <div class="card-body btn toss-bat">
                                        <h5 class="card-title mt-2" >Bat</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="card mt-3 mb-3" id="updateElectedToBowl" data-elected_to="ball" style="width: 7rem;">
                                    <div class="card-body btn toss-bowl ">
                                        <h5 class="card-title mt-2">Bowl</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        <input type="button" data-tournament_id={{$tournament->id}} data-tournament_match_id={{$tournamentMatch->id}} name="next" class="next action-button" id="screenOneNextBtn" value="Next"/>
                    </fieldset>
                    <fieldset>
                        <h2 class="fs-title">Select Playing XI</h2>
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start" >
                                <div class="card mt-3 mb-3" style="width: 7rem;">
                                    <button type="button" id="team1Players" class="btn" data-bs-toggle="modal" data-bs-target="#team1Modal">
                                        <div class="card-body">
                                            <h5 class="card-title mt-2">{{$tournamentMatch->team1->name}}</h5>
                                        </div>
                                      </button>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="card mt-3 mb-3" style="width: 7rem;">
                                    <button type="button" id="team2Players" class="btn" data-bs-toggle="modal" data-bs-target="#team2Modal">
                                        <div class="card-body">
                                            <h5 class="card-title mt-2">{{$tournamentMatch->team2->name}}</h5>
                                        </div>
                                      </button>
                                </div>
                            </div>
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                        <input type="button" id="screenTwoNextBtn" name="next" class="next action-button" value="Next"/>
                    </fieldset>
                    <fieldset>
                        <h2 class="fs-title">Select Captain,Vice Captain and Wicket keeper</h2>

                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start" >
                                <div class="card mt-3 mb-3" style="width: 7rem;">
                                    <button type="button" id="updateKeyPlayersOfTeam1" class="btn" data-bs-toggle="modal" data-bs-target="#team1KeyPlayersModal">
                                        <div class="card-body">
                                            <h5 class="card-title mt-2">{{$tournamentMatch->team1->name}}</h5>
                                        </div>
                                      </button>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="card mt-3 mb-3" style="width: 7rem;">
                                    <button type="button" id="updateKeyPlayersOfTeam2" class="btn" data-bs-toggle="modal" data-bs-target="#team2KeyPlayersModal">
                                        <div class="card-body">
                                            <h5 class="card-title mt-2">{{$tournamentMatch->team2->name}}</h5>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>

                        <input type="button" id="screenThreeNextBtn" name="next" class="next action-button" value="Next"/>
                    </fieldset>
                    <fieldset>
                        <h2 class="fs-title">Start Innings</h2>
                        <h3 class="fs-subtitle mt-2">Batting -
                            @if ($tournamentMatch->team1_id==$tournamentMatch->currently_batting)
                                {{$tournamentMatch->team1->name}}
                            @else
                                {{$tournamentMatch->team2->name}}
                            @endif
                        </h3>
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-start" >
                                <div class="card mb-3" style="width: 15rem;">
                                    <button type="button" id="striker" class="btn" data-bs-toggle="modal" data-bs-target="#strikerModal">
                                        <div class="card-body">
                                            <h5 id="strikerName" class="card-title mt-2">Select Striker</h5>
                                        </div>
                                      </button>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="card mb-3" style="width: 15rem;">
                                    <button type="button" id="nonStriker" class="btn" data-bs-toggle="modal" data-bs-target="#nonStrikerModal">
                                        <div class="card-body">
                                            <h5 id="nonStrikerName" class="card-title mt-2">Select Non-striker</h5>
                                        </div>
                                      </button>
                                </div>
                            </div>
                        </div>
                        <h3 class="fs-subtitle mt-2">Bowling -
                            @if ($tournamentMatch->team1_id==$tournamentMatch->currently_batting)
                                {{$tournamentMatch->team2->name}}
                            @else
                                {{$tournamentMatch->team1->name}}
                            @endif
                        </h3>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center" >
                                <div class="card mb-3" style="width: 15rem;">
                                      <button type="button"  class="btn" data-bs-toggle="modal" data-bs-target="#bowlerModal">
                                      <button type="button" id="bowler" class="btn" data-bs-toggle="modal" data-bs-target="#bowlerModal">
                                        <div class="card-body">
                                            <h5 id="bowlerName" class="card-title mt-2">Select Bowler</h5>
                                        </div>
                                      </button>
                                </div>
                            </div>
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>

                        <input type="submit" name="submit" id="startScoring" class="submit action-button" value="Start scoring"/>
                    </fieldset>
                </div>

            </div>
            <!-- link to designify.me code snippets -->

            <!-- /.link to designify.me code snippets -->
        </div>
    </div>

</div>

<!-- /.MultiStep Form -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js" type="text/javascript"></script> --}}


 <!--Team1 Modal-->
 <div class="modal fade" id="team1Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title me-2" id="exampleModalLabel">
            Select {{$tournamentMatch->team1->name}}'s playing XI
          </h5>
          <p class="modal-title">(Currently Selected
            <span id="currentSelectedTeam1Players"> 0</span>/11)
          </p>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="setTeam1Players">
            <div class="row">
                <div class="col-4">
                    <h4>Batsmen</h4>
                    <div id="team1Batters"></div>
                </div>
                <div class="col-4">
                    <h4>Ballers</h4>
                    <div id="team1Ballers"></div>
                </div>
                <div class="col-4">
                    <h4>Allrounders</h4>
                    <div id="team1Allrounders"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveTeam1PlayingXI" disabled="true" data-bs-dismiss="modal" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
</div>

<!--Team2 Modal-->
<div class="modal fade" id="team2Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title me-2" id="exampleModalLabel">Select {{$tournamentMatch->team1->name}}'s playing XI</h5>
          <p class="modal-title">(Currently Selected
            <span id="currentSelectedTeam2Players"> 0</span>/11)
          </p>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="setTeam2Players">
            <div class="row">
                <div class="col-4">
                    <h4>Batsmen</h4>
                    <div id="team2Batters"></div>
                </div>
                <div class="col-4">
                    <h4>Ballers</h4>
                    <div id="team2Ballers"></div>
                </div>
                <div class="col-4">
                    <h4>Allrounders</h4>
                    <div id="team2Allrounders"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveTeam2PlayingXI" class="btn btn-warning" data-bs-dismiss="modal">Save changes</button>
        </div>
      </div>
    </div>
</div>

<!--Striker Modal-->
<div class="modal fade" id="strikerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-4">
                    <h4>Batsmen</h4>
                    <div id="strikerBattersInXI"></div>
                </div>
                <div class="col-4">
                    <h4>Ballers</h4>
                    <div id="strikerBallersInXI"></div>
                </div>
                <div class="col-4">
                    <h4>Allrounders</h4>
                    <div id="strikerAllroundersInXI"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id="updateStriker">Save changes</button>
        </div>
      </div>
    </div>
</div>

<!--Non Striker Modal-->
<div class="modal fade" id="nonStrikerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-4">
                    <h4>Batsmen</h4>
                    <div id="nonStrikerBattersInXI"></div>
                </div>
                <div class="col-4">
                    <h4>Ballers</h4>
                    <div id="nonStrikerBallersInXI"></div>
                </div>
                <div class="col-4">
                    <h4>Allrounders</h4>
                    <div id="nonStrikerAllroundersInXI"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id="updateNonStriker">Save changes</button>
        </div>
      </div>
    </div>
</div>

<!--Bowler Modal-->
<div class="modal fade" id="bowlerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-4">
                    <h4>Batsmen</h4>
                    <div id="battersInXI"></div>
                </div>
                <div class="col-4">
                    <h4>Ballers</h4>
                    <div id="ballersInXI"></div>
                </div>
                <div class="col-4">
                    <h4>Allrounders</h4>
                    <div id="allroundersInXI"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id="updateBowler">Save changes</button>
        </div>
      </div>
    </div>
</div>

 <!--team1KeyPlayers Modal-->
<div class="modal fade" id="team1KeyPlayersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select {{$tournamentMatch->team1->name}}'s Captain,Vice captain & Wicket keeper</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <h4>Playing XI</h4>
                <div class="col-12">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Player Name</th>
                                <th scope="col">Captain</th>
                                <th scope="col">Vice Captain</th>
                                <th scope="col">Wicket Keeper</th>
                              </tr>
                            </thead>
                            <tbody id="team1PlayingXI"></tbody>
                        </table>

                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveKeyPlayersOfTeam1" data-bs-dismiss="modal" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
</div>

<!--team2KeyPlayers Modal-->
<div class="modal fade" id="team2KeyPlayersModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select {{$tournamentMatch->team2->name}}'s Captain,Vice captain & Wicket keeper</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <h4>Playing XI</h4>
                <div class="col-12">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Player Name</th>
                            <th scope="col">Captain</th>
                            <th scope="col">Vice Captain</th>
                            <th scope="col">Wicket Keeper</th>
                          </tr>
                        </thead>
                        <tbody id="team2PlayingXI"></tbody>
                    </table>

            </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="saveKeyPlayersOfTeam2" data-bs-dismiss="modal" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
</div>

<!-- ERROR TOAST -->
<div class="toast-container position-fixed top-0 end-0 p-3 mt-5 me-5">
    <div id="error-toast" class="bg-light text-danger p-2 rounded border border-2 border-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body d-flex">
            <i class="fa fa-times-circle fa-2x me-2" aria-hidden="true"></i>
            <div id="error-toast-body" class="align-self-center">Something went wrong!</div>
        </div>
    </div>
</div>

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
<script src="{{asset('assets/js/slhttp.js')}}"></script>
<script src="{{asset('assets/js/scorer-stepper.js')}}"></script>
<script src="{{asset('assets/js/scorer-ui.js')}}"></script>
<script>


</script>

@endsection
