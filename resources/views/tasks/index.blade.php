@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.min.js') }}"></script>
    <script>
        const table = $('#dtable');

        table.DataTable({
            responsive: true,
            dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {
                'lengthMenu': 'Rodyti _MENU_',
            },
            order: [],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Veiksmai',
                    orderable: false,
                },
            ],
        });

        table.on('change', '.m-group-checkable', function() {
            const set = $(this).closest('table').find('td:first-child .m-checkable');
            const checked = $(this).is(':checked');

            $(set).each(function() {
                if (checked) {
                    $(this).prop('checked', true);
                    $(this).closest('tr').addClass('active');
                }
                else {
                    $(this).prop('checked', false);
                    $(this).closest('tr').removeClass('active');
                }
            });
        });

        table.on('change', 'tbody tr .kt-checkbox', function() {
            $(this).parents('tr').toggleClass('active');
        });
    </script>
@endsection

@section('content')
    @include('partials.notifications')

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutarties') }} {{ $contract->contract_nr }} {{ __('objekto') }} {{ $obj->name }} {{ __('darbai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('contracts.objects.tasks.create', [$contract->id,$obj->id]) }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('Pridėti užduotį') }}
                        </a>
                        <save-done/>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table class="table table-md table-hover table-checkable" id="dtable">
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
                <tbody>
                @foreach($tasks as $task)
                    <tr class="@if($task->special_task) table-warning @endif">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $task->notes_1 }}</td>
                        <td>{{ $task->notes_2 }}</td>
                        <td class="text-center">
                            <check-done task_id="{{ $task->id }}" />
                        </td>
                        <td></td>
                        <td class="nowrap">
                            <div class="d-flex">
                                <a href="{{ route('contracts.objects.tasks.edit', [$contract->id, $obj->id, $task->id]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{ __('Redaguoti') }}">
                                    <i class="la la-edit"></i>
                                </a>
                                <form action="{{ route('contracts.objects.tasks.destroy', [$contract->id, $obj->id, $task->id]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" rel="tooltip" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                        <i class="la la-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
