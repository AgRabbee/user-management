@if(session('success'))
    <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 show" style="right: 15px !important;" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" >
        <div class="toast-header">
            <i class="mdi mdi-check-circle text-success me-2"></i>
            <div class="me-auto fw-medium">Success</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">{{ session('success') }}</div>
    </div>
@endif


@if(session('error'))
    <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 show alert-dismissible" style="right: 15px !important;" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" >
        <div class="toast-header">
            <i class="mdi mdi-check-circle text-danger me-2"></i>
            <div class="me-auto fw-medium">Bootstrap</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">{{ session('error') }}</div>
    </div>
@endif

@foreach($errors->all() as $error)
    <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 show alert-dismissible" style="right: 15px !important;" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
        <div class="toast-header">
            <i class="mdi mdi-check-circle text-danger me-2"></i>
            <div class="me-auto fw-medium">Validation Error</div>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">{{ $error }}</div>
    </div>
@endforeach
