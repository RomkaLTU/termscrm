@extends('layouts.app')

@section('header-css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer-js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>
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
            headerCallback: function(thead, data, start, end, display) {
                thead.getElementsByTagName('th')[0].innerHTML = `
                    <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                        <input type="checkbox" value="" class="m-group-checkable">
                        <span></span>
                    </label>`;
            },
            columnDefs: [
                {
                    targets: 0,
                    width: '30px',
                    className: 'dt-right',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
                        <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">
                            <input type="checkbox" value="" class="m-checkable">
                            <span></span>
                        </label>`;
                    },
                },
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
                    <i class="kt-font-brand flaticon-doc"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('Sutartys') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('contracts.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('Nauja sutartis') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">
            <table class="table table-md table-hover table-checkable" id="dtable">
                <thead>
                <tr>
                    <th></th>
                    <th>{{ __('Numeris') }}</th>
                    <th>{{ __('Statusas') }}</th>
                    <th>{{ __('Galioja iki') }}</th>
                    <th>{{ __('Pratęsimas iki') }}</th>
                    <th>{{ __('Suma') }}</th>
                    <th>{{ __('Sukurta') }}</th>
                    <th>{{ __('Atnaujinta') }}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($contracts as $contract)
                    <tr>
                        <td></td>
                        <td>{{ $contract->contract_nr }}</td>
                        <td>{{ $contract->contract_status }}</td>
                        <td>{{ $contract->validity_value }}</td>
                        <td>{{ $contract->validity_extend_till_value }}</td>
                        <td>{{ $contract->contract_value }}</td>
                        <td>{{ $contract->created_at }}</td>
                        <td>{{ $contract->updated_at }}</td>
                        <td nowrap>
                            <div class="d-flex">
                                <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{ __('Redaguoti') }}">
                                    <i class="la la-edit"></i>
                                </a>
                                <form action="{{ route('contracts.destroy', $contract->id) }}" method="post">
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
