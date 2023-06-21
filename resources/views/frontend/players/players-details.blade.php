
@extends('frontend.layouts.app')
@push('styles')
    <style>
        td a.player-title{
            color:black;
        }
        td a.player-title:hover{
            color:#ffd584;
        }
        body{
            font-family: 'Poppins';
            background: #f0f8ff;
        }
        h1, h2, h3, h4, h5, h6 {
        font-family: "Poppins";
        }
        .custom-bg{
            --bs-table-bg:#f0f8ff;
        }
    </style>
@endpush
@section('main-content')
  <div class="container-fluid">
    <div class="container">
        <h1 class="font mb-5 player text-uppercase">Players</h1>
        <table class="table-responsive table custom-bg">
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
                            <img src="{{asset('/storage/' . $player->photo_path)}}" class="rounded-circle border border-dark" alt="{{$player->first_name}}" width="100px">
                            @else
                            <img src="{{ asset('assets/img/player-avatar.png') }}" class="rounded-circle border border-2 border-dark" alt="{{ $player->first_name }}" width="100px">
                        @endisset
                        </td>
                        <td><a href="{{route('frontend.players.player-stats',$player->slug)}} " class="player-title"  >{{ $player->first_name }} {{$player->last_name}}</a></td>
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

