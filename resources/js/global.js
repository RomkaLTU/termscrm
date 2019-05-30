(function($){
    const axios = require('./http');

    $(function(){

        // ---------------------------------
        // Form validation
        // ---------------------------------

        $('#form').validate({
            ignore: [],
            rules: {
                due_date: {
                    require_from_group: [1, '.due']
                },
                requiring_int: {
                    require_from_group: [1, '.due']
                }
            },
            messages: {
                due_date: {
                    require_from_group: 'Pasirinkite bent 1'
                },
                requiring_int: {
                    require_from_group: 'Pasirinkite bent 1'
                },
            }
        });

        $.extend($.validator.messages, {
            required: 'Privalomas laukas',
        });

        // ---------------------------------
        // Object visit history
        // ---------------------------------
        const $visit_history_modal = $('#visit_history');
        const $visit_history_content = $('#visit_history_content');

        $visit_history_modal.on('show.bs.modal', function(e){
            const contractid = $(e.relatedTarget).data('contractid');
            const objectid = $(e.relatedTarget).data('objectid');
            let visits_html = '';

            axios.get(`visits/${contractid}/${objectid}`).then((response) => {
                const visits = response.data;

                if ( visits.length ) {
                    visits_html += `<div class="kt-list-timeline" v-if="visits.length"><div class="kt-list-timeline__items">`;
                    visits.forEach(function(visit){
                        visits_html += `
                            <div class="kt-list-timeline__item">
                                <span class="kt-list-timeline__badge"></span>
                                <span class="kt-list-timeline__text">${visit.user.name}</span>
                                <span class="kt-list-timeline__time">${visit.created_at}</span>
                            </div>
                        `;
                    });
                    visits_html += `</div></div>`;
                } else {
                    visits_html += 'Nieko nerasta...';
                }

                $visit_history_content.html(visits_html);
            });
        });
        // end Object visit history

        // ---------------------------------
        // Tasks history
        // ---------------------------------
        const $tasks_history_modal = $('#tasks_history');
        const $tasks_history_content = $('#tasks_history_content');

        $tasks_history_modal.on('show.bs.modal', function(e){
            const taskid = $(e.relatedTarget).data('taskid');
            let visits_html = '';

            axios.get(`tasks/${taskid}`).then((response) => {
                const task_visit = response.data;

                if ( task_visit.length ) {
                    visits_html += `<div class="kt-list-timeline" v-if="visits.length"><div class="kt-list-timeline__items">`;
                    task_visit.forEach(function(visit){
                        visits_html += `
                            <div class="kt-list-timeline__item">
                                <span class="kt-list-timeline__badge"></span>
                                <span class="kt-list-timeline__text">${visit.user.name}</span>
                                <span class="kt-list-timeline__time">${visit.date}</span>
                            </div>
                        `;
                    });
                    visits_html += `</div></div>`;
                } else {
                    visits_html += 'Nieko nerasta...';
                }

                $tasks_history_content.html(visits_html);
            });
        });
        // end Tasks history

        // ---------------------------------
        // Confirmations popovers
        // ---------------------------------
        $(document).on('click', '.confirm_action', function(){
            $('.action-need-confirm').removeClass('action-need-confirm');
            $(this).parent().toggleClass('action-need-confirm');
        });

        $(document).on('click','.close_confirmation', function(e){
            e.preventDefault();
            $('.action-need-confirm').removeClass('action-need-confirm');
        });

        $('body').on('click',function(e){
            const $target = $(e.target);
            if (!$target.parents('.confirm-block').length) {
                $('.action-need-confirm').removeClass('action-need-confirm');
            }
        });
        // end confirmations popovers

    })
}(window.jQuery));
