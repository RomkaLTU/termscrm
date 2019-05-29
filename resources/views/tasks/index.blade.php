@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/tasks.js') }}"></script>
@endsection

@section('content')
    @include('partials.notifications')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutarties') }} <a href="{{ route('contracts.edit', $contract->id) }}">{{ $contract->contract_nr }}</a>
                    {{ __('objekto') }} <a href="{{ route('contracts.objects.edit', [$contract->id,$obj->id]) }}">{{ $obj->name }}</a> {{ __('darbai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('contracts.objects.tasks.create', [$contract->id,$obj->id]) }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('Pridėti užduotį') }}
                        </a>
                        @include('partials.save-completed')
                        @include('partials.print-selected')
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <tasks-filter
                :research_areas="{{ $research_areas }}"
                :contract="{{ $contract }}"
                :object="{{ $obj }}"
                :supervisors="{{ json_encode($supervisors) }}">
            </tasks-filter>
            <table data-model="tasks" class="table table-md table-hover table-checkable" id="dtable">
                <thead>
                <tr>
                    <th>{{ __('Nr.') }}</th>
                    <th>{{ __('Darbai/Monitoringas') }}</th>
                    <th>{{ __('Atlikti iki') }}</th>
                    <th>{{ __('Parametrai') }}</th>
                    <th>{{ __('Pastabos 1') }}</th>
                    <th>{{ __('Pastabos 2') }}</th>
                    <th>{{ __('Pažymėti darbus') }}</th>
                    <th>{{ __('Istorija') }}</th>
                    <th></th>
                </tr>
                </thead>
            </table>

            <div class="mb-5 mt-5"></div>

            <table data-model="tasks" class="table table-md table-hover table-checkable" style="display: none" id="dtable2">
                <thead>
                <tr>
                    <th>{{ __('Nr.') }}</th>
                    <th>{{ __('Ekogeologiniai') }}</th>
                    <th>{{ __('Atlikti iki') }}</th>
                    <th>{{ __('Parametrai') }}</th>
                    <th>{{ __('Pastabos 1') }}</th>
                    <th>{{ __('Pastabos 2') }}</th>
                    <th>{{ __('Pažymėti darbus') }}</th>
                    <th>{{ __('Istorija') }}</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="tasks_history" tabindex="-1" role="dialog" aria-labelledby="tasksHistory" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitHistory">Atliktų darbų istorija</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div id="tasks_history_content" class="kt-scroll" data-scroll="true" data-height="200">
                        {{-- AJAX response here --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
