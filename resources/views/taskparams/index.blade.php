@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.min.js') }}"></script>
    <script src="{{ mix('js/taskparams.js') }}"></script>
@endsection

@section('content')
    @include('partials.notifications')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Užduočių parametrai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        @can('manage_contracts')
                            <a href="{{ route('taskparams.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{ __('Naujas parametras') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table data-model="taskparams" class="table table-md table-hover" style="min-width:680px;" id="dtable">
                <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Pavadinimas') }}</th>
                    <th>{{ __('Grupė') }}</th>
                    <th style="width:100px"></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
