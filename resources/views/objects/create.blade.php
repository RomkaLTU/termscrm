@extends('layouts.app')

@section('footer-js')
    <script src="{{ mix('js/objects.js') }}"></script>
@endsection

@section('content')
    @include('partials.notifications')
    <div>
        <form id="form" class="form-horizontal" action="{{ route('contracts.objects.store', $contract->id) }}" method="post" novalidate="">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Sukurti naują sutarties') }} <a href="{{ route('contracts.edit', $contract->id) }}">{{ $contract->contract_nr }}</a>
                            {{ __('objektą') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <object-fields
                        :users="{{ $users }}"
                        :regions="{{ $regions }}"
                        :old="{{ json_encode(session()->getOldInput()) }}"
                        :research_areas="{{ $research_areas }}">
                    </object-fields>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Išsaugoti') }}</button>
                            <a href="{{ route('contracts.objects.index', $contract->id) }}" class="btn btn-secondary">{{ __('Nutraukti') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
