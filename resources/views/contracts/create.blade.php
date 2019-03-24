@extends('layouts.app')

@section('content')

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="la la-close"></i>
            </button>
            <span><strong>Klaida:</strong> {{ Session::get('error') }}</span>
        </div>
    @endif

    <div>
        <form id="form" class="form-horizontal" action="{{ route('contracts.store') }}" method="post" novalidate="">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Sukurti naują sutartį') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <contract-fields></contract-fields>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Sukurti') }}</button>
                            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Nutraukti</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
