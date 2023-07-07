@extends('frontend.layouts.auth.app')
@push('styles')
    <style>
        .margin-top-10{
            margin-top: 50px
        }
        body{
            background: #d3d3d3;
        }
        .br-10{
            border-radius: 15px;
        }
        .error{
            color:#dc3545;
        }
        a.register{
            color:black;
        }
        a.register:hover{
            color:#ffd584;
        }



    </style>

@endpush
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js" type="text/javascript"></script>

<script>
    $(function() {
        $("#login").validate({
        rules: {
            email: {
                required: true,
                email:true,
            },
            password: {
                required: true,
            }
        },
    });
});
</script>
@endsection
@section('main-content')
    <div class="container">
        <div class="card margin-top-10 shadow p-3 mb-5 bg-white br-10">
            <div class="card-body">
                <div class="row d-flex justify-content-evenly">
                    <div class="col-md-6 auth-image">
                        <img src="{{ asset('assets/img/about.jpg') }}" alt="" width="500px" data-tilt>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <form action="{{route('login')}}" method="POST" id="login">
                            @csrf
                            <div class="form-group">
                              <label for="email" class="mb-2 fw-bold">Email address</label>
                              <input type="email" class="form-control @error('email') border-danger text-danger @enderror" id="email" aria-describedby="emailHelp" placeholder="Enter email" class="mb-2" value="{{old('email')}}" name="email">
                              @error('email')
                                    <span class="text-danger">
                                        {{$message}}
                                    </span>
                              @enderror
                                <div>
                                    <small id="emailHelp" class="form-text text-muted mb-3 ">We'll never share your email with anyone else.</small>
                                </div>
                            </div>
                            <div class="form-group">
                              <label for="password" class="mb-2 mt-3 fw-bold">Password</label>
                              <input type="password" class="form-control @error('email') border-danger text-danger @enderror" id="password" placeholder="Password" class="mb-5" name="password">
                              @error('password')
                              <span class="text-danger">
                                  {{$message}}
                              </span>
                             @enderror
                            </div>
                            <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="rememberMe" class="mt-2">
                              <label class="form-check-label" for="rememberMe" class="mt-5">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-warning mt-2">Submit</button>
                            <div class="mt-2">
                                <a href="{{route('register')}}" class="register" >Haven't signed up yet? Click here to register as organizer.</a>
                            </div>


                          </form>

                    </div>

                </div>




            </div>
        </div>
    </div>
@endsection
