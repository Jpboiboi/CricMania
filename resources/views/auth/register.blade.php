@extends('frontend.layouts.auth.app')
@section('title')
    cric Mania | Register as Organizer
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js" type="text/javascript"></script>

<script>
    $.validator.addMethod('char', function(value, element) {
        return this.optional(element) || (value.match(/[a-zA-Z]/));
    },
    'Password must contain at least  alphabetic character');

    $.validator.addMethod('numeric', function(value, element) {
        return this.optional(element) || (value.match(/[0-9]/) );
    },
    'Password must contain at least  numeric character');

    $.validator.addMethod('special', function(value, element) {
        return this.optional(element) || (value.match(/[_\-!\"@;,.:]/) );
    },
    'Password must contain at least  special character');
    $.validator.addMethod('uppercase', function(value, element) {
        return this.optional(element) || (value.match((/[A-Z]/)) );
    },
    'Password must contain at least  uppercase character');

    $("#register").validate({
        rules: {
            name:{
                required:true,
                minlength:2,
            },
            email: {
                required: true,
                email:true,
            },
            password: {
                required: true,
                minlength: 8,
                char:true,
                numeric:true,
                special:true,
                uppercase:true,



            },
            password_confirmation:{
                required:true,
                equalTo: "#password",
            }
        },
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
                        <form action="{{route('register')}}" method="POST" id="register">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="mb-2 fw-bold">Name</label>
                                <input type="text" class="form-control @error('name') border-danger text-danger @enderror" id="name"  placeholder="Name" class="mb-2" value="{{old('name')}}" name="name">
                                @error('name')
                                      <span class="text-danger">
                                          {{$message}}
                                      </span>
                                @enderror

                              </div>
                            <div class="form-group">
                              <label for="email" class="mb-2 fw-bold">Email address</label>
                              <input
                                type="email"
                                class="form-control @error('email') border-danger text-danger @enderror"
                                id="email"
                                aria-describedby="emailHelp"
                                placeholder="Enter email"
                                class="mb-2" value="{{old('email')}}"
                                name="email"
                                >
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
                              <input type="password" class="form-control @error('password') border-danger text-danger @enderror" id="password" placeholder="Password" class="mb-5" name="password">
                              @error('password')
                              <span class="text-danger">
                                  {{$message}}
                              </span>
                             @enderror
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="mb-2 mt-3 fw-bold">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') border-danger text-danger @enderror" id="password_confirmation" placeholder="Confirm Password" class="mb-5" name="password_confirmation">
                                @error('password_confirmation')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                               @enderror
                              </div>

                            <button type="submit" class="btn btn-warning mt-2">Submit</button>
                            <div class="mt-2">
                                <a href="{{route('login')}}" class="register" >Already registered?</a>
                            </div>


                        </form>

                    </div>

                </div>




            </div>
        </div>
    </div>
@endsection
