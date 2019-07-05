(function($){
    $(function(){
        const $table = $('#dtable');
        const model = $table.data('model');

        if ( $table.length ) {
            $table.DataTable({
                'ajax': `${model}/json`,
                'processing': true,
                'serverSide': true,
                'scrollX': true,
                'searching': true,
                'dom': `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                'lengthMenu': [5, 10, 25, 50],
                'pageLength': 10,
                'order': [],
                'language': {
                    'lengthMenu': 'Rodyti _MENU_',
                },
                'columnDefs': [
                    {
                        'targets': -2,
                        'className': 'w-100px',
                    },
                    {
                        'targets': -1,
                        'title': 'Veiksmai',
                        'orderable': false,
                        'className': 'nowrap w-100px',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                            <div class="d-flex">
                                <a href="/${model}/${row.DT_RowData.rowid}/edit" data-toggle="confirmation" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i class="la la-edit"></i>
                                </a>
                                <div class="action-confirmation">
                                    <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md confirm_action">
                                        <i class="la la-trash"></i>
                                    </button>
                                    <div class="confirm-block">
                                        <form action="/${model}/${row.DT_RowData.rowid}" method="post">
                                            <input type="hidden" name="_token" value="${window.CSRF}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <div>
                                                <div class="d-flex">
                                                    <button type="submit" rel="tooltip" data-toggle="confirmation" class="btn btn-sm btn-danger mr-1">
                                                        Trinti
                                                    </button>
                                                    <button type="button" rel="tooltip" data-toggle="confirmation" class="btn btn-sm btn-clean close_confirmation">
                                                        Atšaukti
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                        }
                    },
                ],
            });
        }
    });
}(window.jQuery));
