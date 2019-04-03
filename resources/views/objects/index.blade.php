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
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

        </div>
    </div>
@endsection
