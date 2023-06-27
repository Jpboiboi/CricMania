@extends('frontend.layouts.app')

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .page-item.active .page-link {
            color: #444;
            background: #ffc451;
            border: #ffc451;
        }
    </style>
@endpush

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets/js/tournaments.ajax.js') }}"></script>
    <script type="text/javascript">
        initAjaxRoute("{{ route('frontend.tournaments.index') }}", "{{csrf_token()}}");
    </script>
@endsection

@section('main-content')

<div class="container mb-3">
    <div class="d-flex justify-content-between">
        <h1 class="mt-3">Tournaments</h1>
        <div class="d-flex align-self-center me-1">
            <a class="btn btn-dark text-warning" href="{{route('tournaments.create')}}"><i class="fa fa-plus me-2"></i>Create Tournament</a>
        </div>
    </div>

    <table class="table table-bordered" id="data-table">
        <thead>

            <tr>
                <th>No</th>
                <th>Name</th>
                <th>No of Teams</th>
                <th>No of Overs</th>
                <th>Start Date</th>
                <th>Organized By</th>
                <th width="105px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection
