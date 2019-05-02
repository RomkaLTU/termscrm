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
            searching: true,
            dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            order: [],
            language: {
                'lengthMenu': 'Rodyti _MENU_',
            },
            columnDefs: [
                {
                    targets: -1,
                    title: 'Veiksmai',
                    orderable: false,
                    className: 'nowrap',
                    "type":"html",
                    "render": function (data, type, row) {
                        return `
                            <div class="d-flex">
                                <a href="contracts/${row.DT_RowData.contractid}/edit" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i class="la la-edit"></i>
                                </a>
                                <form action="contracts/${row.DT_RowData.contractid}" method="post">
                                    <input type="hidden" name="_token" value="${window.CSRF}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" rel="tooltip" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                        <i class="la la-trash"></i>
                                    </button>
                                </form>
                            </div>
                        `;
                    }
                },
            ],
            "processing": true,
            "serverSide": true,
            "ajax": "contracts/json",
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
                    <th>{{ __('Numeris') }}</th>
                    <th>{{ __('Statusas') }}</th>
                    <th>{{ __('Galioja iki') }}</th>
                    <th>{{ __('Pratęsimas iki') }}</th>
                    <th>{{ __('Suma €') }}</th>
                    <th>{{ __('Sukurta') }}</th>
                    <th>{{ __('Atnaujinta') }}</th>
                    <th></th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
