@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/objects.js') }}"></script>
@endsection

@section('content')
    @include('partials.notifications')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutarties') }} {{ $contract->contract_nr }} {{ __('objektai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('contracts.objects.create', $contract->id) }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('Pridėti objektą') }}
                        </a>
                        <button id="save_visited" class="btn btn-success btn-icon-sm" style="display:none;">
                            <i class="la la-check"></i>
                            Saugoti aplankytus (<span id="visited_count"></span>)
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table data-model="objects" class="table table-md table-hover table-checkable" id="dtable">
                <thead>
                <tr>
                    <th>{{ __('#') }}</th>
                    <th>{{ __('Objektas') }}</th>
                    <th>{{ __('Rekvizitai') }}</th>
                    <th>{{ __('Regionas') }}</th>
                    <th>{{ __('Tyrimo sritys') }}</th>
                    <th>{{ __('Pastabos 1') }}</th>
                    <th>{{ __('Pastabos 2') }}</th>
                    <th>{{ __('Aplankyti') }}</th>
                    <th>{{ __('Istorija') }}</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="visit_history" tabindex="-1" role="dialog" aria-labelledby="visitHistory" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitHistory">Apsilankymų istorija</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div id="visit_history_content" class="kt-scroll" data-scroll="true" data-height="200">
                        {{-- AJAX response here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
