@extends('layouts.app')

@section('footer-js')
    <script src="{{ asset('js/tasks.js') }}"></script>
@stop

@section('content')
    @include('partials.notifications')
    <div>
        <form id="form" class="form-horizontal" action="{{ route('contracts.objects.tasks.update', [ $contract->id, $obj->id, $task->id ]) }}" method="post" novalidate="">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Redaguoti užduotį') }}: <strong>{{ $task->name }}</strong>
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <task-fields
                        :obj="{{ $obj }}"
                        :task="{{ $task }}"
                        :contract="{{ $contract }}"
                        :task_params="{{ $task_params }}"
                        :research_area="{{ json_encode($research_area) }}"
                        :research_areas="{{ json_encode($research_areas) }}"
                    />
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Atnaujinti') }}</button>
                            <a href="{{ route('contracts.objects.tasks.index',[$contract->id, $obj->id]) }}" class="btn btn-secondary">{{ __('Nutraukti') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
