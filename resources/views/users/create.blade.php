@extends('layouts.app')

@section('content')
    <div>
        <form id="form" class="form-horizontal" action="{{ route('users.store') }}" method="post" novalidate="">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Sukurti naują vartotoją') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <user-fields :roles="{{ $roles }}"></user-fields>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Išsaugoti') }}</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Nutraukti</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
