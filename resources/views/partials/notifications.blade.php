@if ( Session::has('message') )
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="la la-close"></i>
        </button>
        <span><strong>{{ __('Atlikta:') }}</strong> {!! Session::get('message') !!}</span>
    </div>
@endif

@if ( Session::has('error') )
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="la la-close"></i>
        </button>
        <span><strong>{{ __('Klaida:') }}</strong> {!! Session::get('error') !!}</span>
    </div>
@endif
