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
<div class="container">
    <!-- MultiStep Form -->
    <div class="row d-flex justify-content-center">
    {{-- <div class="row"> --}}
        <div class="col-md-9 height">
            <form id="msform" method="POST" >
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
                        <div class="col-md-4 d-flex justify-content-start">
                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row" name="stricker">
                                    <h5 class="card-title mt-1">Stricker</h5>
                                    <h6>(0.2/5)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row" name="nonstricker">
                                    <h5 class="card-title mt-1">Non-Stricker</h5>
                                    <h6>(0.2/5)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row" name="stricker">
                                    <h5 class="card-title mt-1">Bowler</h5>
                                        <div id="bowl1" class="col-md-2"><h6>0</h6></div>
                                        <div id="bowl2" class="col-md-2"><h6>0</h6></div>
                                        <div id="bowl3" class="col-md-2"><h6>0</h6></div>
                                        <div id="bowl4" class="col-md-2"><h6>0</h6></div>
                                        <div id="bowl5" class="col-md-2"><h6>0</h6></div>
                                        <div id="bowl6" class="col-md-2"><h6>0</h6></div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row"> --}}
                        {{-- <div class="col-md-12 d-flex justify-content-center"> --}}
                            {{-- <div class="card mt-1 mb-3" style="width: 39%;">
                                <div class="card-body row" name="stricker">
                                    <h5 class="card-title mt-1">Bowler</h5>
                                    {{-- <div class="row"> --}}
                                        {{-- <div class="col-md-2"><h6>0</h6></div>
                                        <div class="col-md-2"><h6>0</h6></div>
                                        <div class="col-md-2"><h6>0</h6></div>
                                        <div class="col-md-2"><h6>0</h6></div>
                                        <div class="col-md-2"><h6>0</h6></div>
                                        <div class="col-md-2"><h6>0</h6></div> --}}
                                    {{-- </div> --}}

                                {{-- </div>
                            </div> --}}
                        {{-- </div> --}}
                    {{-- </div> --}}

                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="card mt-1 mb-3" style="width: 100%;">
                                <div class="card-body row">
                                        <div class="col-md-3">
                                            {{-- <a href="">0</a> --}}
                                            <div id="0" class="btn btn-score" style="border: solid 1px #d3d3d3">0</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="1" class="btn btn-score" style="border: solid 1px #d3d3d3">1</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="2" class="btn btn-score" style="border: solid 1px #d3d3d3">2</div>
                                        </div>
                                        <div class="col-md-3">
                                            <div id="undo" class="btn btn-score" style="border: solid 1px green">Undo</div>
                                        </div>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-3">
                                        {{-- <a href="">0</a> --}}
                                        <div id="3" class="btn btn-score" style="border: solid 1px #d3d3d3">3</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="4" class="btn btn-score" style="border: solid 1px #d3d3d3">4</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="6" class="btn btn-score" style="border: solid 1px #d3d3d3">6</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="w" class="btn btn-score" style="border: solid 1px red">OUT</div>
                                    </div>
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-3">
                                        {{-- <a href="">0</a> --}}
                                        <div id="wide" class="btn btn-score" style="border: solid 1px #d3d3d3">WD</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="nb" class="btn btn-score" style="border: solid 1px #d3d3d3">NB</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="bye" class="btn btn-score" style="border: solid 1px #d3d3d3">BYE</div>
                                    </div>
                                    <div class="col-md-3">
                                        <div id="lb" class="btn btn-score" style="border: solid 1px #d3d3d3">LB</div>
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
