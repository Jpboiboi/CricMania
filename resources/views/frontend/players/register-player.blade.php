@extends('frontend.layouts.app')


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        label.error {
            display: block;
        }
        .error {
            color:#dc3545;
        }
    </style>
@endpush

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js" type="text/javascript"></script>


    <script>
        $('.select2').select2({
            placeholder: "Select a value",
            allowClear: true
        });

        flatpickr("#dob", {
            altInput: true,
            altFormat: "F j,Y H:i",
            dateFormat: "Y-m-d H:i",
            maxDate: "today"
        });
    </script>


<script>
    $(function() {
        $("#playerForm").validate({
        rules: {
            first_name: {
                required: true,
                minlength: 2
            },
            last_name: {
                required: true,
                minlength: 2
            },
            state: {
                required: true,
            },
            dob: {
                required: true
            },
            fav_playing_spot: {
                required: true,
            },
            specialization: {
                required: true,
            },
            batting_hand: {
                required: true
            },
            jersey_number: {
                required: true
            },
            balling_hand:{
                required:true
            },
            balling_type:{
                required:true
            },
            image:{
                required:true,
            }
        }
    });
});

</script>

@endsection



@section('main-content')
<div class="container">
    <h1 class="mt-3">Please fill your correct details</h1>
    @include('frontend.layouts._alert-messages')
    <form action="{{route('players.update',$player->id)}}" method="POST" enctype="multipart/form-data" id="playerForm">
        @csrf
        @method('PUT')
        <div class="card mt-5 mb-5">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name" class="form-label">First name</label>
                            <input type="text" value="{{ old('first_name') }}" name="first_name" id="first_name"
                                placeholder="Enter first name"
                                class="form-control @error('first_name') border-danger text-danger @enderror">
                            <label id="first_name-error" class="error text-danger"></label>
                            @error('first_name')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last name</label>
                            <input type="text" value="{{ old('last_name') }}" name="last_name" id="last_name"
                                placeholder="Enter last name"
                                class="form-control @error('last_name') border-danger text-danger @enderror">
                            <label id="last_name-error" class="error text-danger"></label>
                            @error('last_name')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="state" class="form-label">State</label>
                            <select name="state" id="state" class="form-control select2">
                                <option></option>
                                <option value="maharastra">Maharashtra</option>
                                <option value="gujrat">Gujrat</option>
                                <option value="madhyapradesh">Madhyapradesh</option>
                                <option value="punjab">Punjab</option>
                                <option value="tamilnadu">Tamilnadu</option>
                            </select>
                            <label id="state-error" class="error" for="state"></label>
                            @error('state')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob" class="form-label">DOB</label>
                            <input type="date" value="{{ old('dob') }}" name="dob" id="dob"
                                placeholder="Enter DOB"
                                class="form-control @error('dob') border-danger text-danger @enderror" required >
                                <label id="dob-error" class="error text-danger" for="dob"></label>
                            @error('dob')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fav_playing_spot" class="form-label">Fav Playing Spot</label>
                            <input type="text" value="{{ old('fav_playing_spot') }}" name="fav_playing_spot" id="fav_playing_spot"
                                placeholder="Enter your fav playing spot"
                                class="form-control @error('fav_playing_spot') border-danger text-danger @enderror">
                            <label id="fav_playing_spot-error" class="error text-danger" for="fav_playing_spot"></label>
                            @error('fav_playing_spot')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specialization" class="form-label">Specialization</label>
                            <select name="specialization" id="specialization" class="form-control select2">
                                <option></option>
                                <option value="batsman">Batsman</option>
                                <option value="baller">Baller</option>
                                <option value="allrounder">All rounder</option>
                            </select>
                            <label id="specialization-error" class="error text-danger" for="specialization"></label>
                            @error('specialization')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="batting_hand" class="form-label">Batting hand</label>
                            <select name="batting_hand" id="batting_hand" class="form-control select2">
                                <option></option>
                                <option value="right">Right Handed</option>
                                <option value="left">Left Handed</option>
                            </select>
                            <label id="batting_hand-error" class="error text-danger" for="batting_hand"></label>
                            @error('batting_hand')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jersey_number" class="form-label">Jersey Number</label>
                            <input type="text" value="{{ old('jersey_number') }}" name="jersey_number" id="jersey_number"
                                placeholder="Enter your jersey no"
                                class="form-control @error('jersey_number') border-danger text-danger @enderror">
                            <label id="jersey_number-error" class="error text-danger" for="jersey_number"></label>
                            @error('jersey_number')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-2">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="balling_hand" class="form-label">Bowling hand</label>
                            <select name="balling_hand" id="balling_hand" class="form-control select2">
                                <option></option>
                                <option value="right">Right Handed</option>
                                <option value="left">Left Handed</option>
                            </select>
                            <label id="balling_hand-error" class="error text-danger" for="balling_hand"></label>
                            @error('balling_hand')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="balling_type" class="form-label">Balling type</label>
                            <select name="balling_type" id="balling_type" class="form-control select2">
                                <option></option>
                                <option value="fast">Fast</option>
                                <option value="medium-fast">Medium-Fast</option>
                                <option value="spin">Spin</option>
                            </select>
                            <label id="balling_type-error" class="error text-danger" for="balling_type"></label>
                            @error('balling_type')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="form-group">
                            <label for="image" class="form-label">Image</label>
                            <input type="file"
                                    name="image"
                                    id="image"
                                    placeholder="Select Image File"
                                    class="form-control @error('image') border-danger text-danger @enderror">
                                <label id="image-error" class="error text-danger" for="image"></label>
                            @error('image')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group float-end">
                            <button type="submit" class="btn btn-dark text-warning" name="">Submit</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</form>
</div>
@endsection
