@extends('frontend.layouts.app')

@push('styles')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"


  />
  <style>
    .object-fit{
        object-fit: cover;
    }
  </style>

  @endpush

@section('main-content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <div class="col-md-6 m-5"> --}}


        <div class="row d-flex justify-content-center">
            @foreach($teams as $team)
        <div class="col-md-3">
                <div class="card mt-5 mb-5" style="width: 18rem;">
                    <img src="{{ asset($team->image_path)}}" class="card-img-top object-fit " width="100px" height="200px "alt="{{ $team->name}}">
                    <div class="card-body">
                    <h5 class="card-title d-flex justify-content-center mb-3">{{$team->name}}</h5>
                    {{-- <p class="card-text d-flex justify-content-center">Some Slogun.</p> --}}
                    <a href="{{ route('add-players.index', [$tournament->id, $team->id]) }}" class="btn btn-dark text-warning d-flex justify-content-center">Add Players</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>


        {{-- </div>
    </div> --}}
</div>
@endsection
