@extends('frontend.layouts.app')

@push('styles')
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js" type="text/javascript"></script>

<script>
    $(function() {
        $("#emailForm").validate({
        rules: {
            email: {
                required: true,
                email:true,
            }
        },
    });
});

</script>

@endsection

@section('main-content')
    <div class="container mt-5">
        @include('frontend.layouts._alert-messages')
        <form action="{{ route('add-player.sendInvite', [$tournament->id, $team->id]) }}" method="POST" id="emailForm">
            @csrf
            <div class="row">
                <div class="d-flex justify-content-center">
                    <div class="col-md-4">
                        <div class="card mt-5 mb-5">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" value="{{ old('email') }}" name="email" id="email"
                                        placeholder="Enter email"
                                        class="form-control @error('email') border-danger text-danger @enderror">
                                        <label id="email-error" class="error text-danger" for="email"></label>
                                    @error('email')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group float-end mt-3">
                                    <button type="submit" class="btn btn-dark text-warning" name="">Send Invite</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection
