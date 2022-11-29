@if($show_tss_list)
    @include('common-queue.js-with-tss-list')
@else
    @include('common-queue.js-without-tss-list')
@endif
<script>
    var countries_tags ={!! json_encode($countries_tags) !!};
    var tmfsales_tags ={!! json_encode($tmfsales_tags) !!};
    var tss_vars = null;
    var dashboard_params = null;
    var last_formal_status = '';
    var filed_date = '';
    var registered_date = '';

    function changeStatusStart(dashboard_id, root_id, id) {
        $.post(
            '/change-queue-status/dashboard-and-tss-params/' + dashboard_id,
            {root_id: root_id},
            function (msg) {
                if (Object.keys(msg).length) {
                    $('#apply-status-btn').data('dashboard-id', dashboard_id);
                    tss_vars = msg.tss_vars;
                    last_formal_status = msg.last_formal_status;
                    filed_date = msg.filed_date;
                    registered_date = msg.registered_date;
                    dashboard_params = msg.dashboard_params;
                    $('#change-status-modal .modal-body').html(msg.accordion);
                    if (!$('#r-status-collapse-' + root_id).hasClass('show'))
                        $('.r-status[data-id="' + root_id + '"]').trigger('click');
                    $('.s-status[data-id="' + id + '"]').trigger('click');
                    $('#change-status-modal').modal('show');
                } else {
                    new Noty({
                        type: 'error',
                        layout: 'topRight',
                        text: 'Error during getting dashboard params for translator!',
                        timeout: 1500
                    }).show();
                }
            }
        );
    }

    function calculateDate(var_substr, plus_flag, ymd_str, format) {
        var arr_y = ymd_str.split('y');
        var arr_m = arr_y[1].split('m');
        var arr_d = arr_m[1].split('d');
        var y = arr_y[0];
        var m = arr_m[0];
        var d = arr_d[0];
        if (plus_flag)
            return moment(tss_vars[var_substr]['value']).add(y, 'year').add(m, 'month').add(d, 'day').format(format);
        else
            return moment(tss_vars[var_substr]['value']).subtract(y, 'year').subtract(m, 'month').subtract(d, 'day').format(format);
    }

    function translateDateVars(var_substr, template, format) {
        var result = template;
        if (result.indexOf('%%%' + var_substr + '+') != -1 || result.indexOf('%%%' + var_substr + '-') != -1) {
            var splitted_template = result.split('%%%' + var_substr);
            var reg;
            $.each(splitted_template, function (i, val) {
                if (i > 0 && val.indexOf('%%%') != -1) {
                    var local_arr = val.split('%%%');
                    var plus = true;
                    var need_replace = false;
                    var arr = [];
                    if (local_arr[0].indexOf('+') != -1) {
                        need_replace = true;
                        arr = local_arr[0].split('+');
                    }

                    if (local_arr[0].indexOf('-') != -1) {
                        plus = false;
                        need_replace = true;
                        arr = local_arr[0].split('-');
                    }

                    if (need_replace) {
                        var date = calculateDate(var_substr, plus, arr[1], format);
                        if (plus)
                            reg = new RegExp('%%%' + var_substr + '\\+' + arr[1] + '%%%', "g");
                        // reg = new RegExp(var_substr + '\\+' + arr[1], "g");
                        else
                            reg = new RegExp('%%%' + var_substr + '-' + arr[1] + '%%%', "g");
                        // reg = new RegExp(var_substr + '-' + arr[1], "g");
                        result = result.replace(reg, date);
                    }
                }
            });
        }
        return result;
    }

    function canada_us_crutch(template) {
        var reg = new RegExp('canada&gt;', "g");
        template = template.replace(reg, 'can&gt;');
        reg = new RegExp('&lt;us&gt;', "g");
        template = template.replace(reg, '&lt;usa&gt;');
        reg = new RegExp('&lt;/us&gt;', "g");
        template = template.replace(reg, '&lt;/usa&gt;');
        reg = new RegExp('&lt;!us&gt;', "g");
        template = template.replace(reg, '&lt;!usa&gt;');
        reg = new RegExp('&lt;/!us&gt;', "g");
        template = template.replace(reg, '&lt;/!usa&gt;');
        return template;
    }

    function clearTagsAndContentBetweenTags(tag, template) {
        var result = '';
        var arr = template.split('&lt;' + tag + '&gt;');
        $.each(arr, function (i, val) {
            if (val.indexOf('&lt;/' + tag + '&gt;') == -1) {
                result += val;
            } else {
                var local_arr = val.split('&lt;/' + tag + '&gt;');
                result += local_arr[1];
            }
        });
        return result;
    }

    function clearTags(tag, template) {
        var reg = new RegExp('&lt;' + tag + '&gt;', "g");
        template = template.replace(reg, '');
        reg = new RegExp('&lt;/' + tag + '&gt;', "g");
        return template.replace(reg, '');
    }

    function translateTags(current_code, tags, template) {
        // console.log(current_country_code);
        $.each(tags, function (i, val) {
            if (val != current_code) {
                if (template.indexOf('&lt;' + val) != -1)
                    template = clearTagsAndContentBetweenTags(val, template);
                if (template.indexOf('&lt;!' + val) != -1)
                    template = clearTags('!' + val, template);
                if (template.indexOf('&lt;not_' + val) != -1)
                    template = clearTags('not_' + val, template);
            } else {
                // template = clearTags(val, template);
                if (template.indexOf('&lt;' + val) != -1)
                    template = clearTags(val, template);
                if (template.indexOf('&lt;!' + val) != -1)
                    template = clearTagsAndContentBetweenTags('!' + val, template);
                if (template.indexOf('&lt;not_' + val) != -1)
                    template = clearTagsAndContentBetweenTags('not_' + val, template);
            }
        });
        return template;
    }

    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    }

    function handleJsPrompt(template) {
        var result = template;
        if (result.indexOf('&lt;jsprompt&gt;') != -1) {
            var splitted_template = result.split('&lt;jsprompt&gt;');
            $.each(splitted_template, function (i, val) {
                if (val.indexOf('&lt;/jsprompt&gt;') != -1) {
                    var local_arr = val.split('&lt;/jsprompt&gt;');
                    var answer = null;
                    do {
                        answer = prompt($('<textarea/>').html(local_arr[0]).text())
                    } while (!answer || !$.trim(answer).length);
                    // bootbox.prompt($('<textarea/>').html(local_arr[0]).text(), function(result){ console.log(result); });
                    var reg = new RegExp('&lt;jsprompt&gt;' + escapeRegExp(local_arr[0]) + '&lt;/jsprompt&gt;', "g");
                    result = result.replace(reg, answer);
                }
            });
        }
        return result;
    }

    var jscalendar_model = [];
    var jscalendar_index = 0;
    var orig_template;

    function showJsCalendarModal() {
        $('#js-calendar-save-btn').data('index', jscalendar_index);
        $('#jscalendar-question').html(jscalendar_model[jscalendar_index].question);
        $('#jscalendar').val(moment().format(jscalendar_model[jscalendar_index].format));
        $('#jscalendar').datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (dateText, inst) {
                var current_value = this.value;
                this.value = moment(current_value).format(jscalendar_model[jscalendar_index].format);
            }
        });
        $('#js-calendar-modal').modal('show');
    }

    function replaceJsCalendarTags() {
        var template = orig_template;
        $.each(jscalendar_model, function (i, val) {
            var replace_str = '&lt;jscalendar[' + val.format + ']&gt;' + val.question + '&lt;/jscalendar&gt;';
            // var reg = new RegExp(replace_str, "g");
            template = template.replace(replace_str, val.answer);
        });
        translated_template = translateTemplate(template);
    }

    $('#js-calendar-modal').on('hidden.bs.modal', function (e) {
        jscalendar_index = $('#js-calendar-save-btn').data('index');
        jscalendar_model[jscalendar_index].answer = moment($('#jscalendar').val()).format(jscalendar_model[jscalendar_index].format);
        jscalendar_index++;
        if (jscalendar_index < jscalendar_modflag_settings.length)
            showJsCalendarModal();
        else
            replaceJsCalendarTags();
    });

    $('body').on('click', '.js_calendar_plus_delta', function () {
        var date = null;
        var input = $('#jscalendar');
        input.val(moment($('#jscalendar').val()).add($(this).data('delta'), 'month').format(jscalendar_model[$('#js-calendar-save-btn').data('index')].format));
    });

    function startJsCalendarHandler(template) {
        handleJsCalendar(template);
    }

    var translated_template;

    function testTranslator(dashboard_id, template_id) {
        $.get(
            '/change-queue-status/load-dashboard-tss-template/' + template_id,
            function (msg) {
                orig_template = msg;
                if (msg.indexOf('&lt;/jscalendar&gt;') != -1)
                    startJsCalendarHandler(msg);
                else
                    translated_template = translateTemplate(msg);
            }
        )
    }


    function handleJsCalendar(template) {
        var result = template;
        jscalendar_model = [];
        jscalendar_index = 0;
        if (result.indexOf('&lt;/jscalendar&gt;') != -1) {
            var splitted_template = result.split('&lt;/jscalendar&gt;');
            $.each(splitted_template, function (i, val) {
                if (val.indexOf('&lt;jscalendar[') != -1) {
                    var arr0 = val.split('&lt;jscalendar[');
                    var arr = arr0[1].split(']&gt;');
                    var obj = {};
                    obj.format = arr[0];
                    obj.question = $('<textarea/>').html(arr[1]).text();
                    obj.answer = '';
                    jscalendar_modflag_settings.push(obj);
                }
            });
            jscalendar_index = 0;
            showJsCalendarModal();
        } else
            replaceJsCalendarTags();
    }

    function translateTemplate(template) {
        var result = template;
        var reg = new RegExp('%%%OA_ISSUES%%%', "g");
        result = result.replace(reg, '');

        $.each(tss_vars, function (key, value) {
            var reg = new RegExp('%%%' + key + '%%%', "g");
            result = result.replace(reg, value['value']);
        });

        var How_Long_Before_Online_Txt = dashboard_params.How_Long_Before_Online_Txt;
        var reg = new RegExp('%%%How_Long_Before_Online_Txt%%%', "g");
        result = result.replace(reg, How_Long_Before_Online_Txt);

        var How_Long_Before_Online_Math = dashboard_params.How_Long_Before_Online_Math;
        var reg = new RegExp('How_Long_Before_Online_Math', "g");
        result = result.replace(reg, How_Long_Before_Online_Math);

        var How_Long_To_FirstReview_Txt = dashboard_params.How_Long_To_FirstReview_Txt;
        var reg = new RegExp('%%%How_Long_To_FirstReview_Txt%%%', "g");
        result = result.replace(reg, How_Long_To_FirstReview_Txt);

        var How_Long_To_FirstReview_Math = dashboard_params.How_Long_To_FirstReview_Math;
        var reg = new RegExp('How_Long_To_FirstReview_Math', "g");
        result = result.replace(reg, How_Long_To_FirstReview_Math);

        var How_Long_To_ROA_Txt = dashboard_params.How_Long_To_ROA_Txt;
        var reg = new RegExp('%%%How_Long_To_ROA_Txt%%%', "g");
        result = result.replace(reg, How_Long_To_ROA_Txt);

        var How_Long_To_ROA_Math = dashboard_params.How_Long_To_ROA_Math;
        var reg = new RegExp('How_Long_To_ROA_Math', "g");
        result = result.replace(reg, How_Long_To_ROA_Math);

        var How_Long_To_Oppose_Txt = dashboard_params.How_Long_To_Oppose_Txt;
        var reg = new RegExp('%%%How_Long_To_Oppose_Txt%%%', "g");
        result = result.replace(reg, How_Long_To_Oppose_Txt);

        var How_Long_To_Oppose_Math = dashboard_params.How_Long_To_Oppose_Math;
        var reg = new RegExp('How_Long_To_Oppose_Math', "g");
        result = result.replace(reg, How_Long_To_Oppose_Math);

        $.each(tss_vars, function (key, value) {
            if (value['type'] == 'date')
                result = translateDateVars(key, result, value['format']);
        });

        var current_country_code = dashboard_params.current_country_code;
        var apponline = dashboard_params.apponline;

        var current_tmfsales = '{{strtolower(\Illuminate\Support\Facades\Auth::user()->Login)}}';
        result = canada_us_crutch(result);
        result = translateTags(current_country_code, countries_tags, result);
        result = translateTags(current_tmfsales, tmfsales_tags, result);
        var current_user = '{{\Illuminate\Support\Facades\Auth::user()->Login}}';
        if (current_user == 'andrei') {
            result = clearTagsAndContentBetweenTags('!andrei', result);
            result = clearTagsAndContentBetweenTags('not_andrei', result);
            result = clearTags('andrei', result);
        } else {
            result = clearTagsAndContentBetweenTags('andrei', result);
            result = clearTags('!andrei', result);
            result = clearTags('not_andrei', result);
        }
        if (Number(apponline)) {
            result = clearTagsAndContentBetweenTags('!apponline', result);
            result = clearTags('apponline', result);
        } else {
            result = clearTagsAndContentBetweenTags('apponline', result);
            result = clearTags('!apponline', result);
        }

        return handleJsPrompt(result);
        // console.log(translated_template);
    }

    $('body').on('click', '.s-status', function () {
        $('.s-status.active').removeClass('active');
        $(this).addClass('active');
    });

    function applyNewStatus(translated_template) {
        $('#tmfwaiting400_modal').modal('show');
        let new_status_root_id = $('.s-status.active').data('root-id');
        let current_status_root_id = $('.sub-status.active').data('root-id');

        let generated_deadlines = [];
        if ($('#apply-status-btn').data('deadlines') !== undefined && $('#apply-status-btn').data('deadlines').length)
            generated_deadlines = generateDeadlinesFromTemplates($('#apply-status-btn').data('deadlines'));
        let warning_flag_date=generateFlagDateFromFlagSettings($('#apply-status-btn').data('warning-flag-settings'),generated_deadlines);
        let danger_flag_date=generateFlagDateFromFlagSettings($('#apply-status-btn').data('danger-flag-settings'),generated_deadlines);
        $.post(
            '/change-queue-status/apply-new-queue-status',
            {
                tss_template_id: $('.tss-list').val(),
                tss_text: translated_template,
                dashboard_id: $('#apply-status-btn').data('dashboard-id'),
                new_status_id: $('.s-status.active').data('id'),
                deadlines: JSON.stringify(generated_deadlines),
                warning_flag_date:warning_flag_date,
                danger_flag_date:danger_flag_date,
                new_status_root_id:new_status_root_id,
                current_status_root_id:current_status_root_id
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                }, 1000);

/*                reloadSubStatuses(current_status_root_id);
                reloadSubStatuses(new_status_root_id);
                setTimeout(function () {
                    loadSubStatusTms($('.sub-status.active').data('id'));
                }, 1000);*/
            }
        );
    }

    $('#apply-status-btn').click(function () {
        if ($('.tss-list').val() == null) {
            new Noty({
                type: 'error',
                layout: 'topRight',
                text: 'TSS template is empty!',
                timeout: 1500
            }).show();
            return false;
        }
        $('#change-status-modal').modal('hide');

        let template_id = $('.tss-list').val();

        $.post(
            '/change-queue-status/load-dashboard-tss-template-and-deadlines/' + template_id,
            {queue_status_id: $('.s-status.active').data('id')},
            function (msg) {
                orig_template = msg.template;
                $('#apply-status-btn').data('deadlines', msg.deadlines);
                $('#apply-status-btn').data('warning-flag-settings', msg.warning_flag_settings);
                $('#apply-status-btn').data('danger-flag-settings', msg.danger_flag_settings);
                if (msg.template.indexOf('&lt;/jscalendar&gt;') != -1)
                    startJsCalendarHandler(msg.template);
                else {
                    let translated_template = translateTemplate(msg.template);
                    // console.log(translated_template);
                    applyNewStatus(translated_template);
                }
            }
        );
    });

    function generateRemindersFromTemplates(reminders, deadline_date) {
        var result = [];
        $.each(reminders, function (i, el) {
            var obj = {};
            obj.who = el.who;
            var reminder_date = '';
            if (el.plus_minus == '1')
                reminder_date = moment(deadline_date).add(el.year, 'year').add(el.month, 'month').add(el.day, 'day').format('YYYY-MM-DD');
            else
                reminder_date = moment(deadline_date).subtract(el.year, 'year').subtract(el.month, 'month').subtract(el.day, 'day').format('YYYY-MM-DD');
            obj.date = reminder_date;
            result.push(obj);
        });
        return result;
    }

    (function () {
        var moment;
        moment = (typeof require !== "undefined" && require !== null) &&
        !require.amd ? require("moment") : this.moment;

        moment.fn.businessDiff = function (start) {
            start = moment(start);
            var end = this.clone();
            var start_offset = start.day() - 7;
            var end_offset = end.day();

            var end_sunday = end.clone().subtract('d', end_offset);
            var start_sunday = start.clone().subtract('d', start_offset);
            var weeks = end_sunday.diff(start_sunday, 'days') / 7;

            start_offset = Math.abs(start_offset);
            if (start_offset == 7)
                start_offset = 5;
            else if (start_offset == 1)
                start_offset = 0;
            else
                start_offset -= 2;


            if (end_offset == 6)
                end_offset--;

            return weeks * 5 + start_offset + end_offset;
        };

        moment.fn.businessAdd = function (days,hours) {
            var d = this.clone().add(Math.floor(days / 5) * 7,'day').add(hours,'hour');
            var remaining = days % 5;
            if(hours)
                remaining = (days+1) % 5;
            while (remaining) {
                d.add(1,'d');
                if (d.day() !== 0 && d.day() !== 6)
                    remaining--;
            }
            return d;
        };

    }).call(this);

    function generateDeadlinesFromTemplates(deadlines) {
        var result = [];
        $.each(deadlines, function (i, el) {
            var obj = {};
            obj.deadline_type = el.deadline_type;
            obj.deadline_action = el.deadline_action;
            obj.tmfsales = el.tmfsales;
            var moment_obj = {};
            var deadline_date = '';
            switch (el.relative_data_type.id) {
                case 1:
                    moment_obj = moment();
                    break;
                case 2:
                    moment_obj = moment(last_formal_status);
                    break;
                case 3:
                    moment_obj = moment(filed_date);
                    break;
                case 4:
                    moment_obj = moment(registered_date);
                    break;
                case 5:
                    moment_obj = moment(prompt('Enter date:'));
                    break;
            }
            switch (Number(el.plus_minus_settings)) {
                case 1:
                    if (el.plus_minus == '+')
                        deadline_date = moment_obj.add(el.year, 'year').add(el.month, 'month').add(el.day, 'day').format('YYYY-MM-DD');
                    else
                        deadline_date = moment_obj.subtract(el.year, 'year').subtract(el.month, 'month').subtract(el.day, 'day').format('YYYY-MM-DD');
                    break;
                case 2:
                    var dd = {};
                    if (el.plus_minus == '+')
                        dd = moment_obj.add(el.year, 'year').add(el.month, 'month').add(el.day, 'day');
                    else
                        dd = moment_obj.subtract(el.year, 'year').subtract(el.month, 'month').subtract(el.day, 'day');
                    if (dd.format('E') > 5)
                        deadline_date = moment(dd).add(8 - dd.format('E'), 'day').format('YYYY-MM-DD');
                    else
                        deadline_date = dd.format('YYYY-MM-DD');
                    break;
                case 3:
                    deadline_date = moment_obj.businessAdd(el.day).format('YYYY-MM-DD');
                    break;
            }
            obj.date = deadline_date;
            if (el.reminders.length)
                obj.reminders = generateRemindersFromTemplates(el.reminders, deadline_date);
            else
                obj.reminders = [];
            result.push(obj);
        });
        return result;
    }

    function generateFlagDateFromFlagSettings(flag_settings, deadlines) {
        let result = '';
        var moment_obj = {};
        switch (flag_settings.relative_data_type.id) {
            case 1:
                moment_obj = moment();
                break;
            case 2:
                moment_obj = moment(last_formal_status);
                break;
            case 3:
                moment_obj = moment(filed_date);
                break;
            case 4:
                moment_obj = moment(registered_date);
                break;
            case 5:
                moment_obj = moment(prompt('Enter date:'));
                break;
            case 6:
                let deadline_date='';
                $.each(deadlines,function (i,val) {
                    if(val.deadline_type==1)//hard deadline
                        deadline_date=val.date;
                });
                if(deadline_date.length)
                    moment_obj = moment(deadline_date);
                else
                    moment_obj = moment();
                break;
        }
        switch (Number(flag_settings.plus_minus_settings)) {
            case 1:
                if (flag_settings.plus_minus == '+')
                    result = moment_obj.add(flag_settings.year, 'year').add(flag_settings.month, 'month').add(flag_settings.day, 'day').add(flag_settings.hour, 'hour').format('YYYY-MM-DD');
                else
                    result = moment_obj.subtract(flag_settings.year, 'year').subtract(flag_settings.month, 'month').subtract(flag_settings.day, 'day').subtract(flag_settings.hour, 'hour').format('YYYY-MM-DD');
                break;
            case 2:
                var dd = {};
                if (flag_settings.plus_minus == '+')
                    dd = moment_obj.add(flag_settings.year, 'year').add(flag_settings.month, 'month').add(flag_settings.day, 'day').add(flag_settings.day, 'hour');
                else
                    dd = moment_obj.subtract(flag_settings.year, 'year').subtract(flag_settings.month, 'month').subtract(flag_settings.day, 'day').subtract(flag_settings.hour, 'hour');
                if (dd.format('E') > 5)
                    result = moment(dd).add(8 - dd.format('E'), 'day').format('YYYY-MM-DD');
                else
                    result = dd.format('YYYY-MM-DD');
                break;
            case 3:
                result = moment_obj.businessAdd(flag_settings.day,flag_settings.hour).format('YYYY-MM-DD');
                break;
        }
        return result;
    }


</script>