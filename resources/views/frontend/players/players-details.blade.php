
@extends('frontend.layouts.app')
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        .page-link{
            color:black
        }
        .page-item.active .page-link {
            background-color:#ffd584;
            color:black
        }
    </style>
@endpush
@section('main-content')
  <div class="container-fluid">
    <div class="container">
        <h1 class="font mb-5 player text-uppercase">Players</h1>
        <table class="table-responsive table custom-bg" id="data-table">
            <thead>
                <th> </th>
                <th>Name</th>
                <th>Dob</th>
                <th>State</th>
                <th>Specialization</th>
                <th>Jersey No</th>
                <th width="105px">View Stats</th>
            </thead>
            @foreach ($players as $player )
                <tbody>
                    <tr>
                        <td>
                            @isset($player->photo_path)
                            <img src="{{ssset('/storage/'.$player->photo_path)}}" alt="{{$player->first_name}}" class="rounded-circle border border-2 border-dark" width="100px">
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
    </div>
  </div>

@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets/js/players.ajax.js') }}"></script>
    <script type="text/javascript">
        PlayersAjaxRoute("{{ route('frontend.players.player-details') }}", "{{csrf_token()}}");
    </script>

@endsection

