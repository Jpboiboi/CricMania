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
    .modal-dialog-center{
        margin-top:18%;
    }


  </style>

  @endpush

@section('main-content')
<div class="container">
    <!-- MultiStep Form -->
    <div class="row d-flex justify-content-center">
        <div class="col-md-9 height">
            <form id="msform" method="POST">
                @csrf
                <fieldset>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start">
                            <h4>CSK</h4>
                            {{-- <h2 class="fs-title">CSK</h2> --}}
                        </div>
                        <div id="score" class="col-md-6 d-flex justify-content-end">
                            <h4>0/0</h4>
                            <h6 class="ms-2 mt-2">(0/5)</h6>

                        </div>
                    </div>
                    <h3 class="fs-subtitle mt-2">Winner won the toss and elected to bat/bowl.</h3>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start">
                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row" name="stricker">
                                    <div class="col-md-10">
                                        <h5 class="card-title mt-1">Striker</h5>
                                        <h6>(0.2/5)</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#changeStrikerModal">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                          </button>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center">
                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row" name="nonstricker">
                                    <div class="col-md-10">
                                        <h5 class="card-title mt-1">Non Striker</h5>
                                        <h6 >(0.2/5)</h6>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#changeNonStrikerModal">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                          </button>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row " name="bowler">
                                    <div class="col-md-11">
                                        <h5 class="card-title mt-1 d-flex justify-content-center">Bowler</h5>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#changeBowlerModal">
                                            <i class="fa fa-ellipsis-v fa-lg" aria-hidden="true"></i>
                                          </button>
                                    </div>
                                      <div class="d-flex justify-content-center over-balls">
                                        <div id="bowl1" class="col-md-1"><h6>0</h6></div>
                                        <div id="bowl2" class="col-md-1"><h6>0</h6></div>
                                        <div id="bowl3" class="col-md-1"><h6>0</h6></div>
                                        <div id="bowl4" class="col-md-1"><h6>0</h6></div>
                                        <div id="bowl5" class="col-md-1"><h6>0</h6></div>
                                        <div id="bowl6" class="col-md-1"><h6>0</h6></div>
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">

                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row">

                                        <div class="col-md-3">
                                            <div id="0" class="btn btn-outline-dark btn-score">0</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="1" class="btn btn-outline-dark btn-score">1</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="2" class="btn btn-score btn-outline-dark">2</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="undo" class="btn btn-outline-success btn-score">Undo</div>
                                        </div>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-3">
                                        <div id="3" class="btn btn-outline-dark btn-score">3</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="4" class="btn btn-outline-dark btn-score">4</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="6" class="btn btn-outline-dark btn-score">6</div>
                                    </div>
                                    <div class="col-md-3" id="outBtn" data-bs-toggle="modal" data-bs-target="#selectOutTypeModal">
                                        <div id="w" class="btn btn-outline-danger btn-score">OUT</div>
                                    </div>
                                </div>
                                <div class="card-body row">
                                  <div class="col-md-3" id="wdBtn" data-bs-toggle="modal" data-bs-target="#WdDetails">
                                    <div id="wd" class="btn btn-outline-warning btn-score text-dark">WD</div>
                                </div>
                                    <div class="col-md-3" id="nbBtn" data-bs-toggle="modal" data-bs-target="#selectNBModal">
                                        <div id="nb" class="btn btn-outline-warning btn-score text-dark">NB</div>
                                    </div>
                                    <div class="col-md-3" id="byeBtn" data-bs-toggle="modal" data-bs-target="#selectByesModal">
                                        <div id="bye" class="btn btn-outline-info btn-score">BYE</div>
                                    </div>
                                    <div class="col-md-3" id="lbBtn" data-bs-toggle="modal" data-bs-target="#selectLegByesModal">
                                        <div id="lb" class="btn btn-outline-info btn-score">LB</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="button" name="next" class="next action-button col-md-4" value="Next"/>
                </fieldset>

            </form>
      </div>
    </div>

</div>

<!-- /.MultiStep Form -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js" type="text/javascript"></script> --}}

<div class="modal fade" id="selectBowlerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-center" role="document">
        <form method="POST" action="" id="selectBowlerForm">
            @csrf
            <div class="modal-content modal-content-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Bowler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <button class="btn btn-warning" type="submit">player1</button>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="selectOutTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="" id="selectOutTypeForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Out How</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body row">
                        <div class="col-md-4">
                            {{-- <a href="">0</a> --}}
                            <div id="0" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;">Bowled</div>
                        </div>
                        <div class="col-md-4">
                                <div id="0" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;" data-bs-toggle="modal" data-bs-target="#caughtDetails" >Caught</div>
                        </div>
                        <div class="col-md-4">
                            <div id="2" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;">Stumped</div>
                        </div>

                    </div>

                    <div class="card-body row">
                        <div class="col-md-4">
                            {{-- <a href="">0</a> --}}
                            <div id="0" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;">LBW</div>
                        </div>
                        <div class="col-md-4">
                            <div id="1" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;">Hit Wicket</div>
                        </div>
                        <div class="col-md-4">
                            <div id="2" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;">Retired Out</div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div id="undo" class="btn btn-score" style="border: solid 1px green">Undo</div>
                        </div> --}}
                    </div>
                    <div class="card-body row">
                        <div class="col-md-4">
                            <div id="0" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;" data-bs-toggle="modal" data-bs-target="#runOutDetails">Run Out</div>

                        </div>
                        <div class="col-md-4">
                            <div id="1" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;">Mankaded</div>
                        </div>
                        <div class="col-md-4">
                            <div id="filedObstruction" class="btn btn-score" style="border: solid 1px #d3d3d3; width: 100%;">Field Obstruction</div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div id="undo" class="btn btn-score" style="border: solid 1px green">Undo</div>
                        </div> --}}
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="selectLegByesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-center" role="document">
        <form method="POST" action="" id="selectLegByesForm">
            @csrf
            {{-- @method('DELETE') --}}
            {{-- @method('POST') --}}
            <div class="modal-content modal-content-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">How many runs did they run??</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body row">
                        <div class="col-md-4">
                            {{-- <a href="">0</a> --}}
                            <div id="lby1" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">1</div>
                        </div>
                        <div class="col-md-4">
                            <div id="lby2" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">2</div>
                        </div>
                        <div class="col-md-4">
                            <div id="lby3" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">3</div>
                        </div>

                    </div>

                    <div class="card-body row">
                        <div class="col-md-4">
                            {{-- <a href="">0</a> --}}
                            <div id="lby4" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">4</div>
                        </div>
                        <div class="col-md-4">
                            <div id="lby5" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">5</div>
                        </div>
                        <div class="col-md-4">
                            <div id="lby6" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">6</div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div id="undo" class="btn btn-score" style="border: solid 1px green">Undo</div>
                        </div> --}}
                    </div>
                    {{--  --}}
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="selectByesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-center" role="document">
        <form method="POST" action="" id="selectByesForm">
            @csrf
            {{-- @method('DELETE') --}}
            {{-- @method('POST') --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title sm-6" id="exampleModalLabel">How many runs did they run??</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card-body row">
                        <div class="col-md-4">
                            {{-- <a href="">0</a> --}}
                            <div id="bye1" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">1</div>
                        </div>
                        <div class="col-md-4">
                            <div id="bye2" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">2</div>
                        </div>
                        <div class="col-md-4">
                            <div id="bye3" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">3</div>
                        </div>

                    </div>

                    <div class="card-body row">
                        <div class="col-md-4">
                            {{-- <a href="">0</a> --}}
                            <div id="bye4" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">4</div>
                        </div>
                        <div class="col-md-4">
                            <div id="bye5" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">5</div>
                        </div>
                        <div class="col-md-4">
                            <div id="bye6" class="btn btn-score" data-bs-dismiss="modal" style="border: solid 1px #d3d3d3; width: 100%;">6</div>
                        </div>
                        {{-- <div class="col-md-3">
                            <div id="undo" class="btn btn-score" style="border: solid 1px green">Undo</div>
                        </div> --}}
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="selectNBModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-center" role="document">
        <form method="POST" action="" id="selectNBForm">
            @csrf
            {{-- @method('DELETE') --}}
            {{-- @method('POST') --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title sm-6" id="exampleModalLabel">Was there a run-out on No Ball</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Select Yes or No</h5>
                    <div class="card-body row">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#noBallWicketDetails">Yes</button>
                    <button class="btn btn-secondary" type="button"  data-bs-toggle="modal" data-bs-target="#noBallRunsDetails">No</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>

<script src="{{asset('assets/js/scorer.js')}}"></script>
<script>
    // $('#bowlerBtn').click(function(e) {
    //     e.preventDefault();
    //     document.getElementById("selectBowlerForm").setAttribute("action");
    // })
    // function selectBowlerModalHelper(e){
    // }

    // $('#outBtn').click(function(e) {
    //     e.preventDefault();
    //     document.getElementById("selectOutTypeForm").setAttribute("action");
    // })


    // $('#lbBtn').click(function(e) {
    //     e.preventDefault();
    //     document.getElementById("selectLegByesForm").setAttribute("action");
    // })


    // $('#byeBtn').click(function(e) {
    //     e.preventDefault();
    //     // console.log(e.target);
    //     // var byes = document.getElementById("selectOutTypeForm");
    //     // console.log(byes);
    // })


    $('#outBtn').click(function(e) {
        e.preventDefault();
        document.getElementById("selectByesForm").setAttribute("action","action");
    });

    // $('#nbBtn').click(function(e) {
    //     e.preventDefault();
    //     document.getElementById("selectNBForm").setAttribute("action");
    // })



</script>




@endsection

  {{-- Caught details Modal --}}
  <div class="modal fade" id="caughtDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Who took the catch?</h5>
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

  {{-- End of caught details Modal --}}

  {{-- Run out details modal --}}
  <div class="modal fade" id="runOutDetails" aria-hidden="true" aria-labelledby="runOutDetailsLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="runOutDetailsLabel">Who was out?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Striker

                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                  Non-Striker
                </label>
              </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-warning" data-bs-target="#runOutDetails2" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="runOutDetails2" aria-hidden="true" aria-labelledby="runOutDetailsLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="runOutDetailsLabel2">How many runs were scored before run out?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <select class="form-select" aria-label="Default select example">
                <option selected>Runs</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
        </div>
        <div class="modal-footer">
          <button class="btn btn-warning" data-bs-target="#runOutDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
          <button class="btn btn-warning" data-bs-target="#runOutDetails3" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="runOutDetails3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Who took the wicket?</h5>
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
          <button class="btn btn-warning" data-bs-target="#runOutDetails2" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
          <button type="button" class="btn btn-success">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  {{-- End of run out details modal --}}

  {{-- Change Striker Modal --}}
  <div class="modal fade" id="changeStrikerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeStrikerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changeStrikerModalLabel">Change Striker</h5>
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
          <button type="button" class="btn btn-warning">Submit</button>
        </div>
      </div>
    </div>
  </div>
  {{-- End of Change Striker Modal --}}

  {{-- Change Non-Striker Modal --}}
  <div class="modal fade" id="changeNonStrikerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeNonStrikerModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changeNonStrikerModalLabel">Change Non Striker</h5>
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
          <button type="button" class="btn btn-warning">Submit</button>
        </div>
      </div>
    </div>
  </div>
  {{-- End of Change Non-Striker Modal --}}

    {{-- Change Bowler Modal --}}
    <div class="modal fade" id="changeBowlerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeBowlerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="changeBowlerModalLabel">Change Bowler</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label clas s="form-check-label" for="flexRadioDefault1">
                  Player1
                </label>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-warning">Submit</button>
            </div>
          </div>
        </div>
      </div>
      {{-- End of Change Non-Striker Modal --}}

      {{-- no ball wicket details modal --}}
      <div class="modal fade" id="noBallWicketDetails" aria-hidden="true" aria-labelledby="runOutDetailsLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="runOutDetailsLabel">Who was out?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                    <label class="form-check-label" for="exampleRadios1">
                      Striker
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                    <label class="form-check-label" for="exampleRadios2">
                      Non-Striker
                    </label>
                  </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-warning" data-bs-target="#noBallWicketDetails2" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="noBallWicketDetails2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Who took the wicket?</h5>
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
              <button class="btn btn-warning" data-bs-target="#noBallWicketDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
              <button type="button" class="btn btn-warning" data-bs-target="#noBallRunsDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
            </div>
          </div>
        </div>
      </div>
      {{-- end of no ball wicket details modal --}}

      {{-- no ball runs details --}}
      <div class="modal fade" id="noBallRunsDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">How many runs were scored on the no ball?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                 <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupSelect01">Options</label>
                <select class="form-select" id="inputGroupSelect01">
                    <option selected>Choose...</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
                </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-warning" data-bs-target="#selectNBModal" data-bs-toggle="modal" data-bs-dismiss="modal">Reset</button>
              <button type="button" class="btn btn-success">Submit</button>
            </div>
          </div>
        </div>
      </div>
      {{--end of no ball runs details --}}



{{-- Wide ball details --}}
<div class="modal fade" id="WdDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="wdDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="wdDetailsLabel">Wide details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Was there a wicket on wide ball?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning"  data-bs-target="#WdWicketDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Yes</button>
          <button type="button" class="btn btn-secondary" data-bs-target="#WdRunsDetails" data-bs-toggle="modal" data-bs-dismiss="modal">No</button>
        </div>
      </div>
    </div>
  </div>

{{-- End of wide ball details --}}

{{-- Wide wicket details --}}
<div class="modal fade" id="WdWicketDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="WdWicketDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="WdWicketDetailsLabel">Wicket Type</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Select Wicket Type
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger"  data-bs-target="#WdRunOutDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Run Out</button>
          <button type="button" class="btn btn-outline-danger" data-bs-target="#WdStumpedDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Stumped</button>
          <button type="button" class="btn btn-outline-danger" data-bs-target="#WdHitWktDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Hit Wicket</button>
        </div>
      </div>
    </div>
  </div>
{{-- End of wide wicket details --}}

{{-- Wide Run out details --}}
<div class="modal fade" id="WdRunOutDetails" aria-hidden="true" aria-labelledby="runOutDetailsLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="runOutDetailsLabel">Who was out?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  Striker
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                <label class="form-check-label" for="exampleRadios2">
                  Non-Striker
                </label>
              </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-target="#WdWicketDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
          <button class="btn btn-warning" data-bs-target="#WdRunOutDetails2" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="WdRunOutDetails2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Who took the wicket?</h5>
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
          <button class="btn btn-secondary" data-bs-target="#WdRunOutDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
          <button type="button" class="btn btn-warning" data-bs-target="#WdRunsDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Next</button>
        </div>
      </div>
    </div>
  </div>
{{-- End of Wide Run out details --}}

{{-- Wide stumped details --}}
<div class="modal fade" id="WdStumpedDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stumped!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
             <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Runs scored</label>
            <select class="form-select" id="inputGroupSelect01">
                <option selected>Choose...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-target="#WdWicketDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
          <button type="button" class="btn btn-warning">Submit</button>
        </div>
      </div>
    </div>
  </div>
{{-- End of wide stumped details --}}

{{-- Wide hit-wicket details --}}
<div class="modal fade" id="WdHitWktDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hit wicket!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
             <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Runs scored</label>
            <select class="form-select" id="inputGroupSelect01">
                <option selected>Choose...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-target="#WdWicketDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Previous</button>
          <button type="button" class="btn btn-warning">Submit</button>
        </div>
      </div>
    </div>
  </div>
{{-- End of wide hit-wicket details --}}

{{-- Wide runs details --}}
<div class="modal fade" id="WdRunsDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">How many runs were scored during the wide ball?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
             <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupSelect01">Options</label>
            <select class="form-select" id="inputGroupSelect01">
                <option selected>Choose...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-target="#WdDetails" data-bs-toggle="modal" data-bs-dismiss="modal">Reset</button>
          <button type="button" class="btn btn-warning">Submit</button>
        </div>
      </div>
    </div>
  </div>
{{-- End of wide runs details --}}
