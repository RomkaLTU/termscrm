(function($){
    $(function(){

        const $table = $('#dtable');
        const model = $table.data('model');
        const $save_completed = $('#save_completed');
        const $completed_count = $('#completed_count');
        let checkedCompleted = [];

        // ----------------------------------
        // Check tasks
        // ----------------------------------
        $(document).on('change','.completed',function(){
            if ( this.checked ) {
                checkedCompleted.push(this.value);
            } else {
                checkedCompleted = _.without(checkedCompleted, this.value);
            }

            $completed_count.html(checkedCompleted.length);

            if ( checkedCompleted.length ) {
                $save_completed.css('display','inline-block');
            } else {
                $save_completed.css('display','none');
            }
        });

        $save_completed.on('click',function(){
            // TODO
            alert('In progress...');
            // axios.post(`visits`, {
            //     checked: checkedCompleted,
            //     contractid: contractid,
            //     user_id: window.USER_ID,
            // }).then(() => {
            //     window.toastr.success('Apsilankymai išsaugoti');
            //     $('.visited').prop('checked', false);
            //     checkedCompleted = [];
            //     $save_completed.css('display','none');
            // });
            window.toastr.success('Atlikti darbai išsaugoti');
            $('.completed').prop('checked', false);
            checkedCompleted = [];
            $save_completed.css('display','none');
        });

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
                'rowCallback': function(row, data) {
                    if ( data.DT_RowData.special ) {
                        $(row).addClass('table-success');
                    }

                    if ( data.DT_RowData.late ) {
                        $(row).addClass('table-warning');
                    }
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
