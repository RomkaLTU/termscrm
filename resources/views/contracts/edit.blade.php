@extends('layouts.app')

@section('footer-js')

@endsection

@section('content')
<div>
    @include('partials.notifications')

    <form id="form" class="form-horizontal" action="{{ route('contracts.update', $contract->id) }}" method="post" novalidate="">
        <input type="hidden" name="_method" value="PUT">
        @csrf
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        {{ __('Redaguoti sutartį') }}: <strong>{{ $contract->name }}</strong>
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="objektaiBtn" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('Objektai') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="objektaiBtn">
                                <a class="dropdown-item" href="{{ route('contracts.objects.index', $contract->id) }}">{{ __('Sutarties objektai') }}</a>
                                <a class="dropdown-item" href="{{ route('contracts.objects.create', $contract->id) }}">{{ __('Pridėti objektą') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                <contract-fields
                    :research_areas="{{ json_encode($research_areas) }}"
                    :contract="{{ $contract }}"
                    :documents="{{ json_encode($documents) }}">
                </contract-fields>
            </div>
            <div class="kt-portlet__foot">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-success">{{ __('Atnaujinti') }}</button>
                        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Nutraukti</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutarties objektai') }}
                </h3>
            </div>
        </div>
        <div class="kt-portlet__body">

        </div>
    </div>
</div>
@endsection
