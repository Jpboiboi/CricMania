@extends('frontend.layouts.app')

@push('styles')
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
@endpush

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 m-5">
            <form id="create-team-form" action="{{route('teams.store' ,$tournament->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
                <h2>Add Team Details :</h2>
                <div id = "cards">
                    @for ( $i = 0; $i < $tournament->no_of_teams; $i++ )
                    <div class="card mt-4 animate__animated animate__fadeInDown">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="teams[{{$i}}][name]" placeholder="Enter Team Name" value="{{ old('teams[0][name]') }}" class="form-control @error('name') is-invalid @enderror" />
                                @error('teams.*.name')

                                    <span class="text-danger">{{ str_replace("teams.$i.name","name",$message)}}
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image_path" class="form-label mt-3">Logo</label>
                                <input type="file"
                                    class="form-control @error('image_path') border-design text-danger @enderror"
                                    placeholder="Select Image File"

                                    name="teams[{{$i}}][image]">
                                    @error('teams.*.image')
                                        <span class="text-danger">
                                            {{ str_replace("teams.$i.image","image",$message)}}
                                        </span>

                                    @enderror
                            </div>
                        </div>
                    </div>
                    @endfor
                    </div>
                    <div class="form-group mt-3 float-end">
                        <input type="submit" name="submit" id="submit" class="btn btn-dark text-warning mt-2"/>
                        @error('submit')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js" type="text/javascript"></script>
<script>
    $(function() {
        $("#create-team-form").validate();

        var teams = $('input[name^="teams"]');
        teams.filter('input[name$="[name]"]').each(function() {
            $(this).rules("add", {
            required: true,
            messages: {
                required: "The Name field is required."
            }
            });


        teams.filter('input[name$="[image]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required : 'The image field is required.',
                    // image : ''
                    // mimes:png,jpg,svg
                    // max:1024
                }
            });
        });
        });

    });


</script>
