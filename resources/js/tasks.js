(function($){
    const axios = require('./http');

    $(function(){

        const $table = $('#dtable');
        const model = $table.data('model');
        const $save_completed = $('#save_completed');
        const $completed_count = $('#completed_count');
        let checkedVisited = [];
        let contractid = false;

        const $params = $('.select2_task_params');
        const $select2_task_params_groups = $('.select2_task_params_groups');
        const $select2 = $('.select2');

        // ----------------------------------
        // Check tasks
        // ----------------------------------
        $(document).on('change','.completed',function(){
            if ( this.checked ) {
                checkedVisited.push(this.value);
            } else {
                checkedVisited = _.without(checkedVisited, this.value);
            }

            $completed_count.html(checkedVisited.length);
            contractid = $(this).data('contractid');

            if ( checkedVisited.length ) {
                $save_completed.css('display','inline-block');
            } else {
                $save_completed.css('display','none');
            }
        });

        $save_completed.on('click',function(){
            axios.post(`tasks`, {
                checked: checkedVisited,
                user_id: window.USER_ID,
            }).then(() => {
                window.toastr.success('Apsilankymai išsaugoti');
                $('.visited').prop('checked', false);
                checkedVisited = [];
                $save_completed.css('display','none');

                $table.DataTable().ajax.reload(null, false);
            });
        });
        // end Check tasks

        if ( $params.length ) {
            $params.select2({
                placeholder: 'Pridėti parametrą',
                tags: true,
                createTag: function (params) {
                    const term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term + ' (naujas)'
                    };
                },
            });

            // insertinam nauja parametra i DB
            $params.on('select2:select', function(e){
                if ( typeof e.params.data.element === 'undefined' ) {
                    $.post(window.API_DOMAIN + '/tasks/params', {
                        name: e.params.data.id
                    });
                }
            });
        }

        if ( $select2_task_params_groups.length ) {
            $select2_task_params_groups.select2({
                placeholder: 'Parametrų grupės',
            });
        }

        if ( $select2.length ) {
            $select2.select2({
                placeholder: 'Pasirinkite',
                allowClear: true,
            });
        }

        let columnDefs = [
            {
                'targets': 3,
                'orderable': false,
                'type':'html',
                'render': function (data) {
                    if ( data ) {
                        const params_arr = data.split(', ');
                        let html = '';

                        params_arr.forEach((param) => {
                            html += `<span class="kt-badge kt-badge--primary kt-badge--md kt-badge--inline kt-badge--pill mr-1">${param}</span>`;
                        });

                        return html;
                    } else {
                        return null;
                    }
                }
            },
            {
                'targets': -3,
                'title': 'Pažymėti darbus',
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
                },
            },
            {
                'targets': -2,
                'title': 'Istorija',
                'orderable': false,
                'type':'html',
                'render': function (data, type, row) {
                    return `
                            <button data-toggle="modal" 
                                data-contractid="${row.DT_RowData.contractid}" 
                                data-objectid="${row.DT_RowData.objectid}" 
                                data-taskid="${row.DT_RowData.taskid}" 
                                data-target="#tasks_history" class="btn btn-outline-brand btn-sm">
                                Peržiūreti
                            </button>
                        `;
                },
            },
            {
                'targets': -1,
                'title': 'Veiksmai',
                'orderable': false,
                'className': 'nowrap',
                'type':'html',
                'render': function (data, type, row) {
                    return `
                            <div class="d-flex">
                                <a href="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/tasks/${row.DT_RowData.taskid}/edit" data-toggle="confirmation" class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i class="la la-edit"></i>
                                </a>
                                <div class="action-confirmation">
                                    <button type="button" class="btn btn-sm btn-clean btn-icon btn-icon-md confirm_action">
                                        <i class="la la-trash"></i>
                                    </button>
                                    <div class="confirm-block">
                                        <form action="/contracts/${row.DT_RowData.contractid}/objects/${row.DT_RowData.objectid}/tasks/${row.DT_RowData.taskid}" method="post">
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
        ];

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
                'columnDefs': columnDefs,
            });
        }
    });
}(window.jQuery));
