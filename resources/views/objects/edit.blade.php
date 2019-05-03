@extends('layouts.app')

@section('content')
    <div>
        @include('partials.notifications')

        <form id="form" class="form-horizontal" action="{{ route('contracts.objects.update', [ $contract->id, $obj->id ]) }}" method="post" novalidate="">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Redaguoti objektą') }}: <strong>{{ $obj->id }}</strong>
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="tasksBtn" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Darbai') }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="tasksBtn">
                                    <a class="dropdown-item" href="{{ route('contracts.objects.tasks.index', [$contract->id, $obj->id]) }}">{{ __('Objekto darbai') }}</a>
                                    <a class="dropdown-item" href="{{ route('contracts.objects.tasks.create', [$contract->id, $obj->id]) }}">{{ __('Pridėti užduotį') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <button type="submit" class="btn btn-success">{{ __('Atnaujinti') }}</button>
                            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">{{ __('Nutraukti') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
