
@extends('frontend.layouts.app')
@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&family=Staatliches&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        h1 .player{
            font-family: 'Staatliches, cursive';
        }
        td a.player-title{
            color:black;
        }
        td a.player-title:hover{
            color:#ffd584;
        }
    </style>
@endpush
@section('main-content')
  <div class="container-fluid">
    <div class="container">
        <h1 class="font-1 mb-5 player">Players</h1>
        <table class="table-responsive table ">
            <thead>
                <th> </th>
                <th>Name</th>
                <th>Dob</th>
                <th>State</th>
                <th>Specialization</th>
                <th>Jersey No</th>
            </thead>
            @foreach ($players as $player )
                <tbody>
                    <tr>
                        <td>
                            @isset($player->photo_path)
                            <img src="{{$player->photo_path}}" alt="{{$player->first_name}}">
                            @else
                            <img src="{{ asset('assets/img/player-avatar.png') }}" class="rounded-circle bg-light" alt="{{ $player->first_name }}" width="100px">
                        @endisset
                        </td>
                        <td><a href="{{route('frontend.players.player-stats',$player->id)}} " class="player-title" >{{ $player->first_name }} {{$player->last_name}}</a></td>
                        <td>{{ $player->dob }}</td>
                        <td>{{$player->state}}</td>
                        <td>
                            @if($player->specialization === 'baller')
                            {{ $player->balling_type }} {{ $player->specialization }}
                           @else
                            {{ $player->specialization }}
                           @endif
                        </td>
                        <td>{{$player->jersey_number}}</td>


                    </tr>
                </tbody>
            @endforeach

        </table>
        {{$players->links('pagination::bootstrap-5')}}
    </div>
  </div>
@endsection
