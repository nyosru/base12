<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getCheckedArr(selector) {
        var arr=[];
        $(selector+':checked').each(function () {
            arr.push(Number($(this).val()));
        });
        return arr;
    }


    function paintFilter(filter_selector,filter_modal_id,th_selector) {
        var all=$(filter_selector).length;
        var checked=$(filter_selector+':checked').length;
        $(th_selector).html('<a href="#" class="filter-link" data-filter-modal="'+filter_modal_id+'" data-filter-selector="'+filter_selector+'">'+
            checked+' of '+all+
            '</a>'
        );
    }


    var cs_source_data=[];
    var rt;

    $(document).ready(function () {

        var dateFormat = "yy-mm-dd",
            from = $("#from_date")
                .datepicker({
                    changeMonth: true,
                    numberOfMonths: 1,
                    minDate: "2020-06-12",
                    dateFormat: dateFormat
                })
                .on("change", function () {
                    to.datepicker("option", "minDate", getDate(this));
                }),
            to = $("#to_date").datepicker({
                changeMonth: true,
                numberOfMonths: 1,
                dateFormat: dateFormat,
                minDate: "{{$first_date}}",
                maxDate: "2025-06-12",
            })
                .on("change", function () {
                    from.datepicker("option", "maxDate", getDate(this));
                });

        function getDate(element) {
            var date;
            try {
                date = $.datepicker.parseDate(dateFormat, element.value);
            } catch (error) {
                date = null;
            }

            return date;
        }


        $('body').on('change','#pay-type-filter,#client-filter,#client-type-filter,#client-source-filter,#boom-source-filter',function () {
            hideShowRawRevenuesRows();
        });

        $('body').on('click','.filter-link',function () {
            $('#'+$(this).data('filter-modal')+' .apply-filter').data('filter-selector',$(this).data('filter-selector'));
            $('#'+$(this).data('filter-modal')).modal('show');
            return false;
        });


        $( 'body' ).on( 'keyup change','#client-filter-input' ,function () {
/*            rt
                .column( $(this).parent().index())
                .search( this.value )
                .draw();*/
            hideShowRawRevenuesRows();
        } );



        $('#show-data').click(function () {
            $('#tmfwaiting400_modal').modal('show');
            $.post(
                location.href,
                {
                    from_date: $.trim($('#from_date').val()),
                    to_date: $.trim($('#to_date').val()),

                },
                function (msg) {
                    setTimeout(function () {
                        $('#tmfwaiting400_modal').modal('hide');
                    },500);
                    //
                    // $('#results-block').html(msg);
                    // $('#result-block').show();
                    $('#pt-switch-to-block').html('Calculating % from $. <a href="#" class="switch-to" data-to="num" data-selector="#pt-content">Switch to #</a>');
                    $('#ct-switch-to-block').html('Calculating % from $. <a href="#" class="switch-to" data-to="num" data-selector="#ct-content">Switch to #</a>');
                    $('#bs-switch-to-block').html('Calculating % from $. <a href="#" class="switch-to" data-to="num" data-selector="#bs-content">Switch to #</a>');
                    $('#cs-switch-to-block').html('Calculating % from $. <a href="#" class="cs-switch-to" data-to="num">Switch to #</a>');
                    $('#rr-content').html(msg['raw-revenues']);
                    rt=$('#raw-revenues-table').DataTable({
                        // 'searching': false,
                        "paging":   false,
                        "info":     false,
                        orderCellsTop: true,
                        fixedHeader: true,
                        initComplete:function () {
                            paintFilterSettings();
                        }
                    });
                    $('#pt-content').html(msg['pay-type']);
                    $('#ct-content').html(msg['client-type']);
                    $('#bs-content').html(msg['boom-source']);
                    cs_source_data=msg['client-source'];
                    // calculateCsNums();
                    paintCsTable();
                    hideShowRawRevenuesRows();
                    $('#result-block').show();
                    console.log(msg);
                }
            );

        });
    });

    $('.q-btn,.month-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-' + $(this).data('from'));
        $('#to_date').val($('#s-year').val() + '-' + $(this).data('to'));
    });

    $('.y-btn').click(function () {
        $('#from_date').val($('#s-year').val() + '-01-01');
        $('#to_date').val($('#s-year').val() + '-12-31');
    });

    function setYDate(selector){
        var val=$(selector).val();
        if(val.length){
            var arr=val.split('-');
            $(selector).val($('#s-year').val() + '-' + arr[1]+'-'+arr[2]);
        }
    }

    $('#s-year').change(function () {
        setYDate('#from_date');
        setYDate('#to_date');
    });

    $('.apply-filter').click(function () {
        paintFilterSettings();
        hideShowRawRevenuesRows();
    });

    $('.nums-filter').change(function () {
        paintCsTable();
    });

    function getCsTableThCell(cell_index,cell_content,class_name) {
        if($('.nums-filter[value="'+cell_index+'"]').prop('checked'))
            return '<th class="text-center '+class_name+'">'+cell_content+'</th>';
        return '';
    }

    function getCsTableTdCell(cell_index,cell_content,title,class_name) {
        if($('.nums-filter[value="'+cell_index+'"]').prop('checked'))
            return '<td class="text-center '+class_name+'" title="'+title+'">'+cell_content+'</td>';
        return '';
    }

    function getCsHeader0(colspan,caption,class_name) {
        return '<th class="text-center bold-border-left bold-border-right '+class_name+'" colspan="'+colspan+'">'+caption+'</th>'
    }

    $('.toggle-all').click(function () {
        var parent_modal=$(this).parents('.modal:eq(0)');
        var total_chbx=parent_modal.find('input[type="checkbox"]').length;
        var total_chbx_checked=parent_modal.find('input[type="checkbox"]:checked').length;
        if(total_chbx>total_chbx_checked)
            parent_modal.find('input[type="checkbox"]').prop('checked',true);
        else
            parent_modal.find('input[type="checkbox"]').prop('checked',false);
    });


</script>
@include('tmf-revenue-breakdown.js'.$view_suffix)