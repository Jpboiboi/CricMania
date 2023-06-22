@extends('frontend.layouts.app')

@push('styles')

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .page-item.active .page-link {
        color: #444;
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .page-link {
        color: #444
    }

    .added-players {
        padding: 0 10px;
    }
</style>
@endpush

@section('main-content')
    <div class="container mt-5">
        @include('frontend.layouts._alert-messages')
            <div class="text-muted">Required</div>
            <div class="card mt-2 mb-3 border border-danger">
                <div class="card-body">
                    @foreach ($teamPlayers as $teamPlayer)
                    <div class="card mb-2 p-2">
                        <div class="card-body added-players">
                            <div class=" d-flex justify-content-between">
                                @if ($teamPlayer->email_verified_at)
                                    <div>
                                        <div>
                                            <i class="fa fa-check-circle-o text-success"></i>
                                            {{ $teamPlayer->first_name . " " . $teamPlayer->last_name}}
                                        </div>
                                        <div class="text-muted">
                                            {{$teamPlayer->specialization}} | Batting Hand: {{ $teamPlayer->batting_hand}} |
                                            Balling Hand: {{ $teamPlayer->balling_hand}} |
                                            Balling Type: {{
                                            $teamPlayer->balling_type
                                            }}
                                        </div>
                                    </div>
                                    <div class="d-flex align-self-center">
                                        <div>
                                            <a class="btn btn-outline-info me-1" href="{{ route('frontend.players.player-stats', $teamPlayer->slug) }}"><i class="fa fa-eye"></i></a>
                                        </div>
                                        <div>
                                            <form action="{{route('add-players.destroy',[$tournament->id,$team->id,$teamPlayer->id])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                <div>
                                    <div>player email:
                                        {{$teamPlayer->email}}
                                    </div>
                                    <div class="text-muted">
                                        <i class="fa fa-clock-o text-danger"></i>
                                        invitation pending
                                    </div>
                                </div>
                                <div class="d-flex align-self-center">
                                    <div>
                                        <form action="{{route('add-players.destroy',[$tournament->id,$team->id,$teamPlayer->id])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
                    @for ($i=1;$i<=11 - $teamPlayers->count();$i++)
                        <div class="row mt-3 mb-3 ">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="Player-{{$i}}">
                                        player required
                                    </div>
                                    @error('player-{{$i}}')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('players.invite-via-email', [$tournament->id, $team->id])}}" class=" btn btn-outline-info">Invite Via link</a>
                            </div>
                            <div class="col-md-3">
                                <button class=" btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#dataModal" >Choose from available players</button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="text-muted">optional</div>
            <div class="card mt-2 mb-3">
                <div class="card-body">
                    @for ($i=12;$i<=$tournament->max_players;$i++)
                        <div class="row mt-3 mb-3 ">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <div class="Player-{{$i}}">
                                        player optional
                                    </div>
                                    @error('player-{{$i}}')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{route('registration')}}" class=" btn btn-outline-info">Invite Via link</a>
                            </div>
                            <div class="col-md-3">
                                <button class=" btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#dataModal" >Choose from available players</button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="row mt-2 mb-4 mt-3">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <div class="form-group float-end">
                        <button type="submit" class="btn btn-dark text-warning" name="">Submit</button>
                    </div>
                </div>
            </div>
    </div>

    <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="dataModalLabel">Choose a player</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-responsive" style="width: 100%" id="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Batting Hand</th>
                            <th>Balling Hand</th>
                            <th>Balling Type</th>
                            <th>Fav Playing Spot</th>
                            <th width="105px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
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
    console.log({{$team->id}});
        initAjaxRoute("{{ route('frontend.players.add-player') }}", "{{csrf_token()}}", "{{ $tournament->id }}", "{{ $team->id }}");
    </script>

@endsection


