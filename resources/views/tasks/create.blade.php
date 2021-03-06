@extends('layouts.app')

@section('footer-js')
    <script src="{{ mix('js/tasks.js') }}"></script>
@stop

@section('content')
    @include('partials.notifications')
    <div>
        <form id="form" class="form-horizontal" action="{{ route('contracts.objects.tasks.store', [$contract->id,$obj->id]) }}" method="post">
            <input type="hidden" name="object_id" value="{{ $obj->id }}">
            <input type="hidden" name="contract_id" value="{{ $contract->id }}">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Sukurti naują užduotį') }} {{ __('sutarties') }} <a href="{{ route('contracts.edit', $contract->id) }}"> {{ $contract->contract_nr }}</a> {{ __('objektui') }} <a href="{{ route('contracts.objects.edit', [$contract->id,$obj->id]) }}">{{ $obj->name }}</a>
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <task-fields
                        :obj="{{ $obj }}"
                        :research_areas="{{ $research_areas }}"
                        :task_params="{{ $task_params }}"
                        :task_params_selected="[]"
                        :task_params_groups="{{ $task_params_groups }}"
                        :task_params_groups_selected="[]"
                        :is_admin="{{ auth()->user()->hasRole('Admin') ? 1 : 0 }}"
                        :contract="{{ $contract }}"/>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Išsaugoti') }}</button>
                            <a href="{{ route('contracts.objects.tasks.index',[$contract->id,$obj->id]) }}" class="btn btn-secondary">{{ __('Nutraukti') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
