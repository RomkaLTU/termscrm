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

    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="la la-close"></i>
            </button>
            <span><strong>Atlikta:</strong> {{ Session::get('message') }}</span>
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                <i class="la la-close"></i>
            </button>
            <span><strong>Klaida:</strong> {{ Session::get('error') }}</span>
        </div>
    @endif

    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-brand flaticon-users-1"></i>
                </span>
                <h3 class="kt-portlet__head-title">
                    {{ __('Vartotojai') }}
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-wrapper">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('users.create') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                            <i class="la la-plus"></i>
                            {{ __('Naujas vartotojas') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body">

            <!--begin: Datatable -->
            <table class="table table-md table-hover table-checkable" id="dtable">
                <thead>
                <tr>
                    <th></th>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Vardas') }}</th>
                    <th>{{ __('Rolės') }}</th>
                    <th>{{ __('Pareigos') }}</th>
                    <th>{{ __('El. paštas') }}</th>
                    <th>{{ __('Sukurtas') }}</th>
                    <th>{{ __('Veiksmai') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td></td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ implode(',', $user->getRoleNames()->toArray()) }}</td>
                        <td>{{ $user->duties }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td nowrap>
                            <div class="d-flex">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{ __('Redaguoti') }}">
                                    <i class="la la-edit"></i>
                                </a>
                                @if($user->id != auth()->user()->id)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" rel="tooltip" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!--end: Datatable -->
        </div>
    </div>
@endsection
