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
    <!-- MultiStep Form -->
<div class="row d-flex justify-content-center">
    {{-- <div class="row"> --}}
        <div class="col-md-6 height">
            <form id="msform" method="POST" action="{{route('scorer.store')}}" >
                @csrf
                {{-- action="{{route('scorer/matchid/score')}}" --}}
                <!-- progressbar -->
                <div class="progressbar justify-content-center">
                    <ul id="progressbar">
                        <li class="active">Toss & Elect</li>
                        <li>Select Playing XI</li>
                        <li>Start Innings</li>
                    </ul>
                </div>
                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title">Toss</h2>
                    <h3 class="fs-subtitle">Who won the toss?</h3>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start" >
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body btn toss-team1">
                                    <h5 class="card-title mt-2">MI</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body btn toss-team2">
                                    <h5 class="card-title mt-2">CSK</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="fs-subtitle">Winner of the toss elected to?</h3>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start" >
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body btn toss-bat">
                                    <h5 class="card-title mt-2">Bat</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body btn toss-bowl ">
                                    <h5 class="card-title mt-2">Bowl</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                    <input type="button" name="next" class="next action-button" value="Next"/>
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Select Playing XI</h2>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start" >
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#team1Modal">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2">MI</h5>
                                    </div>
                                  </button>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#team2Modal">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2">CSK</h5>
                                    </div>
                                  </button>
                            </div>
                        </div>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                    <input type="button" name="next" class="next action-button" value="Next"/>
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Start Innings</h2>
                    <h3 class="fs-subtitle mt-2">Batting - Team Name</h3>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start" >
                            <div class="card mb-3" style="width: 15rem;">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#strikerModal">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2">Select Striker</h5>
                                    </div>
                                  </button>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="card mb-3" style="width: 15rem;">
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bowlerModal">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2">Select Non-striker</h5>
                                    </div>
                                  </button>
                            </div>
                        </div>
                    </div>
                    <h3 class="fs-subtitle mt-2">Bowling - Team Name</h3>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center" >
                            <div class="card mb-3" style="width: 15rem;">
                                  <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#bowlerModal">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2">Select Bowler</h5>
                                    </div>
                                  </button>
                            </div>
                        </div>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                    <input type="submit" name="submit" class="submit action-button" value="Start scoring"/>
                </fieldset>

            </form>
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card mt-3 mb-3">
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          Player1
                        </label>
                      </div>
                </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
  </div>
    <!--Team2 Modal-->
<div class="modal fade" id="team2Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card mt-3 mb-3">
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                          Player1
                        </label>
                      </div>
                </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
  </div>
    <!--Striker Modal-->
<div class="modal fade" id="strikerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Player1
                </label>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <!--Non Striker Modal-->
<div class="modal fade" id="nonStrikerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Player1
                </label>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
  </div>
    <!--Bowler Modal-->
<div class="modal fade" id="bowlerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Select A Player</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                  Player1
                </label>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
<script src="{{asset('assets/js/scorer.js')}}"></script>
<script src="{{asset('assets/js/scorer-ui.js')}}"></script>
<script>


</script>

@endsection
