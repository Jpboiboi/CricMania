@if (session('success'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toast" class="bg-light text-success p-3 rounded border border-3 border-success" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header pb-2">
        <strong class="me-auto">Cric Mania</strong>
        <small class="pe-2">Now</small>
      </div>
      <div class="toast-body">
        {{ session('success') }}
      </div>
    </div>
  </div>
@endif

@if (session('error'))
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toast" class="bg-light text-danger p-3 rounded border border-3 border-danger" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header pb-2">
        <strong class="me-auto">Cric Mania</strong>
        <small class="pe-2">Now</small>
      </div>
      <div class="toast-body">
        {{ session('error') }}
      </div>
    </div>
  </div>
@endif
