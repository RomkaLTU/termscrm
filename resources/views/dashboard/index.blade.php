@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection

@section('content')
    @include('partials.notifications')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Darbai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        @include('partials.save-completed')
                        @include('partials.print-selected')
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <dashboard-tasks-filter
                :regions="{{ $regions }}"
                :research_areas="{{ $research_areas }}">
            </dashboard-tasks-filter>
            <table data-model="dashboard" class="table table-md table-hover" id="dtable">
                <thead>
                <tr>
                    <th>{{ __('Objektas') }}</th>
                    <th>{{ __('Regionas') }}</th>
                    <th>{{ __('Tyrimai') }}</th>
                    <th>{{ __('Darbas') }}</th>
                    <th>{{ __('Iki kada atlitki') }}</th>
                    <th>{{ __('Pažymėti') }}</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@stop
