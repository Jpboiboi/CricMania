@extends('frontend.layouts.app')


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">

@endpush

@section('scripts')
    {{-- <script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

    <script>
        $('.select2').select2({
            placeholder: "Select a Value",
            allowClear: true
        })

        flatpickr('#start_date', {
            enableTime: true,
            altInput: true,
            altFormat: "F j, Y H:i",
            dateFormat: "Y-m-d H:i",
            minDate: new Date().fp_incr(1),
            minTime: "9:00",
            maxTime: "21:00",
        })
    </script>
@endsection


@section('main-content')
    <div class="container">
        <div class="row">
            <form action="{{route('tournaments.store')}}" method="POST">
                @csrf
                <h2 class="mt-3">Create Tournament</h2>
                <div class="card m-3">
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="name" class="form-label">Name: </label>
                            <input
                                type="text"
                                id="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                name="name"
                                placeholder="Enter Tournament Name">
                            @error('name')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="tournament_type_id" class="form-label">Tournament Type: </label>
                            <select
                                name="tournament_type_id"
                                id="type"
                                class="form-control select2"
                                >
                                <option></option>
                                <option value="1">Season</option>
                                <option value="2">Tennis</option>
                            </select>
                            @error('tournament_type_id')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="no_of_teams" class="form-label">Enter No Of Teams: </label>
                            <select
                                name="no_of_teams"
                                id="no_of_teams"
                                class="form-control select2"
                                >
                                <option></option>
                                <option value="4">4 Teams</option>
                                <option value="6">6 Teams</option>
                                <option value="8">8 Teams</option>
                                <option value="10">10 Teams</option>
                            </select>
                            @error('no_of_teams')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="max_players" class="form-label">Enter Max Players: </label>
                            <input
                                type="text"
                                id="max_players"
                                class="form-control"
                                value="{{ old('max_players') }}"
                                name="max_players"
                                placeholder="Enter Max Players">
                            @error('max_players')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="start_date" class="form-label">Enter Start Date</label>
                            <input
                                type="date"
                                value="{{ old('start_date') }}"
                                class="form-control mb-1 @error('start_date') border-danger @enderror"
                                placeholder="Enter Start Date"
                                id="start_date"
                                name="start_date">
                            @error('start_date')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark text-warning" name="addBlog">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
