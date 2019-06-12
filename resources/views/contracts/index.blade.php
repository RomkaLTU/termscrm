@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dt-custom-init.js') }}"></script>
@endsection

@section('content')
    @include('partials.notifications')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutartys') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        @can('manage_users')
                            <a href="{{ route('contracts.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{ __('Nauja sutartis') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <contracts-filter></contracts-filter>
            <table data-model="contracts" class="table table-md table-hover" style="min-width:680px;" id="dtable">
                <thead>
                <tr>
                    <th>{{ __('Numeris') }}</th>
                    <th>{{ __('Statusas') }}</th>
                    <th>{{ __('Galioja iki') }}</th>
                    <th>{{ __('Pratęsimas iki') }}</th>
                    <th style="width:100px">{{ __('Suma €') }}</th>
                    <th style="width:100px"></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
