@extends('layouts.app')

@section('content')
    <div>
        @include('partials.notifications')

        <form id="form" class="form-horizontal" action="{{ route('contracts.objects.update', [ $contract->id, $obj->id ]) }}" method="post" novalidate="">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body">
                    <object-fields
                        :contract="{{ $contract }}"
                        :obj="{{ $obj }}"
                        :documents="{{ json_encode($documents) }}"
                        :research_area="{{ json_encode($research_area) }}"
                        :research_areas="{{ json_encode($research_areas) }}">
                    </object-fields>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Sukurti') }}</button>
                            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">{{ __('Nutraukti') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
