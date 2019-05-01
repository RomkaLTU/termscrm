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
                <span class="kt-portlet__head-icon">
                    <i class="fa kt-font-brand fa-map-marker-alt"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutarties') }} {{ $contract->contract_nr }} {{ __('objektai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('contracts.objects.create', $contract->id) }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('Pridėti objektą') }}
                        </a>
                        <save-visited :contract_id="{{ $contract->id }}"></save-visited>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table class="table table-md table-hover table-checkable" id="dtable">
                <thead>
                <tr>
                    <th>{{ __('Numeris') }}</th>
                    <th>{{ __('Objektas') }}</th>
                    <th>{{ __('Rekvizitai') }}</th>
                    <th>{{ __('Regionas') }}</th>
                    <th>{{ __('Tyrimo sritys') }}</th>
                    <th>{{ __('Pastabos 1') }}</th>
                    <th>{{ __('Pastabos 2') }}</th>
                    <th>{{ __('Pažymėti aplankytus') }}</th>
                    <th>{{ __('Istorija') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($objs as $obj)
                    <tr>
                        <td>{{ $obj->id }}</td>
                        <td>{{ $obj->name }}</td>
                        <td>{{ $obj->details }}</td>
                        <td></td>
                        <td>
                            {{ implode(', ', $obj->researchAreas->pluck('name')->toArray()) }}
                        </td>
                        <td>{{ $obj->notes_1 }}</td>
                        <td>{{ $obj->notes_2 }}</td>
                        <td>
                            <div class="text-center">
                                <check-visited :contract_id="{{ $contract->id }}" :object_id="{{ $obj->id }}"></check-visited>
                            </div>
                        </td>
                        <td>
                            <visit-history :contract_id="{{ $contract->id }}" :object_id="{{ $obj->id }}"></visit-history>
                        </td>
                        <td nowrap>
                            <div class="d-flex">
                                <a href="{{ route('contracts.objects.edit', [$contract->id, $obj->id]) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{ __('Redaguoti') }}">
                                    <i class="la la-edit"></i>
                                </a>
                                <form action="{{ route('contracts.objects.destroy', [$contract->id, $obj->id]) }}" method="post">
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
