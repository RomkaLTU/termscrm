@extends('layouts.app')

@section('content')
    @include('partials.notifications')
    <div>
        <form id="form" class="form-horizontal" action="{{ route('contracts.objects.store', $contract->id) }}" method="post" novalidate="">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Sukurti naują objektą') }}
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <object-fields :research_areas="{{ json_encode($research_areas) }}"></object-fields>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Sukurti') }}</button>
                            <a href="{{ route('contracts.objects.index', $contract->id) }}" class="btn btn-secondary">{{ __('Nutraukti') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection