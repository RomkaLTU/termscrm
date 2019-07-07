@extends('layouts.app')

@section('content')
    <div>
        @include('partials.notifications')

        <form id="form" class="form-horizontal" action="{{ route('taskparams.update', [$task_param->id]) }}" method="post" novalidate="">
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{ __('Redaguoti parametrą') }} {{ $task_param->name }}
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                                <button id="tasksBtn" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('Parametrai') }}
                                </button>
                                <div class="dropdown-menu" aria-labelledby="tasksBtn">
                                    <a class="dropdown-item" href="{{ route('taskparams.index') }}">{{ __('Visi parametrai') }}</a>
                                    <a class="dropdown-item" href="{{ route('taskparams.create') }}">{{ __('Pridėti naują') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <task-params-fields
                        :research_area="{{ $research_area }}"
                        :research_areas="{{ $research_areas }}"
                        :task_param="{{ $task_param }}">
                    </task-params-fields>
                </div>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success">{{ __('Atnaujinti') }}</button>
                            <a href="{{ route('taskparams.index') }}" class="btn btn-secondary">{{ __('Nutraukti') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
