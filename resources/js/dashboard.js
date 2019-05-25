(function($){
    $(function(){

        const $table = $('#dtable');
        const model = $table.data('model');

        if ( $table.length ) {
            $table.DataTable({
                'ajax': `${model}/json`,
                'processing': true,
                'serverSide': true,
                'responsive': true,
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
                        'targets': 0,
                        'title': 'Objektas',
                        'orderable': false,
                        'className': '',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                                <a href="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/edit">${data}</a>
                            `;
                        }
                    },
                    {
                        'targets': 3,
                        'title': 'Darbas',
                        'orderable': false,
                        'className': '',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                                <a href="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/tasks/${row.DT_RowData.taskid}/edit">${data}</a>
                            `;
                        }
                    },
                    {
                        'targets': -1,
                        'title': 'Veiksmai',
                        'orderable': false,
                        'className': 'text-center',
                        'type':'html',
                        'render': function (data, type, row) {
                            return `
                                <label class="kt-checkbox">
                                    <input class="completed" type="checkbox" name="completed[]" value="${row.DT_RowData.taskid}"> &nbsp;
                                    <span></span>
                                </label>
                            `;
                        }
                    },
                ],
            });
        }

    });
}(window.jQuery));
