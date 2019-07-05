(function($){
    const axios = require('./http');

    $(function(){

        const $table = $('#dtable');
        const model = $table.data('model');
        const $save_completed = $('#save_completed');
        const $print_selected = $('#print_selected');
        const $completed_count = $('.completed_count');
        let checkedVisited = [];

        // ----------------------------------
        // Check tasks
        // ----------------------------------
        $(document).on('change','.completed',function(){
            if ( this.checked ) {
                checkedVisited.push(this.value);
            } else {
                checkedVisited = _.without(checkedVisited, this.value);
            }

            const checkedCount = checkedVisited.length;

            $print_selected.attr( 'data-taskids', checkedVisited.join(',') );

            if ( checkedCount ) {
                $save_completed.css('display','inline-block');
                $print_selected.css('display','inline-block');
            } else {
                $save_completed.css('display','none');
                $print_selected.css('display','none');
            }

            $completed_count.text(checkedCount);
        });
        // check task

        $(document).on('click', '#print_selected', function(e){
            e.preventDefault();
            const $this = $(this);

            const pdfGenerateUrl = $this.attr('href');
            const taskids = $this.attr('data-taskids');

            // console.log(`${pdfGenerateUrl}/?tasks=${taskids}`);

            window.location.href = `${pdfGenerateUrl}/?tasks=${taskids}`;
        });

        $save_completed.on('click',function(){

            axios.post(`tasks`, {
                checked: checkedVisited,
                user_id: window.USER_ID,
            }).then(() => {
                window.toastr.success('Atlikta');
                $('.visited').prop('checked', false);
                checkedVisited = [];
                $save_completed.css('display','none');

                $table.DataTable().ajax.reload(null, false);
            });

        });

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
