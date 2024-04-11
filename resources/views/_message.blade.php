@if (!empty(session('error')))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
    </div>
@endif

@if (!empty(session('warning')))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
    </div>
@endif

@if (!empty(session('success')))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (!empty(session('info')))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
    </div>
@endif

@if (!empty(session('secondary')))
    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        {{ session('secondary') }}
    </div>
@endif

@if (!empty(session('primary')))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ session('primary') }}
    </div>
@endif

@if (!empty(session('payment-error')))
    <div class="alert alert-error alert-dismissible fade show" role="alert">
        {{ session('payment-error') }}
    </div>
@endif

@if (!empty(session('light')))
    <div class="alert alert-light alert-dismissible fade show" role="alert">
        {{ session('light') }}
    </div>
@endif

