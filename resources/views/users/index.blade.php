@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/dt-custom-init.js') }}"></script>
@endsection

@section('content')
    @include('partials.notifications')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Vartotojai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('users.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('Naujas vartotojas') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <table data-model="users" class="table table-md table-hover table-checkable" id="dtable">
                <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Vardas') }}</th>
                    <th>{{ __('Rolės') }}</th>
                    <th>{{ __('Pareigos') }}</th>
                    <th>{{ __('El. paštas') }}</th>
                    <th>{{ __('Sukurtas') }}</th>
                    <th>{{ __('Veiksmai') }}</th>
                </tr>
                </thead>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
@endsection
