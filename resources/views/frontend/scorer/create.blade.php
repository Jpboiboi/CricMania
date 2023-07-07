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
                <ul id="progressbar">
                    <li class="active">Select Match</li>
                    <li>Toss</li>
                    <li>Start Innings</li>
                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title">Active Matches</h2>
                    <h3 class="fs-subtitle">Select the match you want to score.</h3>
                    {{-- <input type="text" name="fname" placeholder="First Name"/> --}}
                    {{-- <input type="text" name="lname" placeholder="Last Name"/> --}}
                    {{-- <input type="text" name="phone" placeholder="Phone"/> --}}
                    @for ( $i = 0; $i < 2; $i++ )
                    <div class="card-body d-flex justify-content-start mt-2">
                        Team vs Team

                    </div>
                    {{-- <div class="card mt-3 mb-3" style="width: 28rem;"> --}}
                        {{-- <img src="{{ asset($team->image_path)}}" class="card-img-top object-fit " width="100px" height="200px "alt="{{ $team->name}}"> --}}
                        {{-- <div class="card-body row" name="card[{{$i}}]"> --}}
                        {{-- <h5 class="card-title d-flex justify-content-center mb-3">{{$team->name}}</h5> --}}
                            {{-- <h5 class="card-title d-flex justify-content-start mt-2">Team vs Team</h5> --}}
                        {{-- <a href="{{ route('add-players.index', [$tournament->id, $team->id]) }}" class="btn btn-dark text-warning d-flex justify-content-center">Add Players</a> --}}
                        {{-- </div> --}}
                    {{-- </div> --}}
                    @endfor
                    <input type="button" name="next" class="next action-button col-md-4" value="Next"/>

                {{-- </div> --}}


                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Toss</h2>
                    <h3 class="fs-subtitle">Who won the toss?</h3>
                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start" >
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">MI</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body ">
                                    <h5 class="card-title mt-2">CSK</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="fs-subtitle">Winner of the toss elected to?</h3>

                    <div class="row">
                        <div class="col-md-6 d-flex justify-content-start" >
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Bat</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="card mt-3 mb-3" style="width: 7rem;">
                                <div class="card-body ">
                                    <h5 class="card-title mt-2">Bowl</h5>
                                </div>
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
                                <div class="card-body">
                                    <h6 class="card-title mt-2">Select Stricker</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <div class="card mb-3" style="width: 15rem;">
                                <div class="card-body ">
                                    <h6 class="card-title mt-2">Select Non-Stricker</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="fs-subtitle mt-2">Bowling - Team Name</h3>
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center" >
                            <div class="card mb-3" style="width: 15rem;">
                                <div class="card-body">
                                    {{-- <h6 class="card-title mt-2">Select Bowler</h6> --}}
                                    <button class="btn" id="bowlerBtn" data-bs-toggle="modal" data-bs-target="#selectBowlerModal">
                                    <h6 class="card-title mt-2">Select Bowler</h6>

                                        {{-- <i class="fa fa-trash"></i> --}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                    <input type="submit" name="submit" class="submit action-button" value="Submit"/>
                    {{-- <a href="{{ route('') }}" type="submit" name="submit" class="submit action-button" value="Submit" class="btn btn-dark text-warning d-flex justify-content-center">Submit</a> --}}
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

<div class="modal fade" id="selectBowlerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="" id="selectBowlerForm">
            @csrf
            {{-- @method('DELETE') --}}
            {{-- @method('POST') --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Bowler</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- @foreach ( as ) --}}

                    {{-- @endforeach --}}
                    <button class="btn btn-warning" type="submit">player1</button>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
<script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
<script src="{{asset('assets/js/scorer.js')}}"></script>
<script>
    $('#bowlerBtn').click(function(e) {
        e.preventDefault();
        document.getElementById("selectBowlerForm").setAttribute("action");
    })
    function selectBowlerModalHelper(e){
    }
</script>

@endsection
