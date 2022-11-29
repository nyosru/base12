<script>
    function hideShowRawRevenuesRows() {
        var show=1;
        var filter_pay_type=getCheckedArr('.pay-type-filter-chbx');
        var filter_client=$.trim($('#client-filter-input').val());
        var filter_client_type=getCheckedArr('.client-type-filter-chbx');
        var filter_client_source=getCheckedArr('.client-source-filter-chbx');
        var filter_boom_source=getCheckedArr('.boom-source-filter-chbx');
        $('.raw-revenues-row').each(function () {
            show=1;
            var current_pay_type=Number($(this).data('pay-type'));
            var current_client=$.trim($(this).find('td:eq(2)').text());
            var current_client_type=Number($(this).data('client-type'));
            var current_client_source=Number($(this).data('client-source'));
            var current_boom_source=Number($(this).data('boom-source'));

            if(filter_pay_type.length) {
                if ($.inArray(current_pay_type,filter_pay_type)==-1)
                    show = 0;
            }else
                show=0;

            if(filter_client.length)
                if(current_client.toLowerCase().indexOf(filter_client.toLowerCase())==-1)
                    show=0;

            if(filter_client_type.length) {
                if ($.inArray(current_client_type,filter_client_type)==-1)
                    show = 0;
            }else
                show=0;

            if(filter_client_source.length) {
                if ($.inArray(current_client_source,filter_client_source)==-1)
                    show = 0;
            }else
                show=0;

            if(filter_boom_source.length) {
                if ($.inArray(current_boom_source,filter_boom_source)==-1)
                    show = 0;
            }else
                show=0;

            if(show)
                $(this).show();
            else
                $(this).hide();
        });
    }

    function paintFilterSettings() {
        paintFilter('.pay-type-filter-chbx','pay-type-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(4)');
        paintFilter('.client-type-filter-chbx','client-type-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(3)');
        paintFilter('.client-source-filter-chbx','client-source-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(5)');
        paintFilter('.boom-source-filter-chbx','boom-source-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(6)');
    }


    Number.prototype.formatMoney = function(c, d, t){
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }


    $('body').on('click','.switch-to',function () {
        var to=$(this).data('to');
        var selector=$(this).data('selector');
        if(to=='num'){
            $(selector+' .amount-percent').hide();
            $(selector+' .num-percent').show();
            $(this).parents('.switch-to-block:eq(0)').html('Calculating % from #. <a href="#" class="switch-to" data-to="amount" data-selector="'+selector+'">Switch to $</a>');
        }else{
            $(selector+' .amount-percent').show();
            $(selector+' .num-percent').hide();
            $(this).parents('.switch-to-block:eq(0)').html('Calculating % from $. <a href="#" class="switch-to" data-to="num" data-selector="'+selector+'">Switch to #</a>');
        }
        return false;
    });


    $('body').on('click','.cs-switch-to',function () {
        var to=$(this).data('to');
        if(to=='num'){
            $(this).parents('.cs-switch-to-block:eq(0)').html('Calculating % from #. <a href="#" class="cs-switch-to" data-to="amount">Switch to $</a>');
        }else{
            $(this).parents('.cs-switch-to-block:eq(0)').html('Calculating % from $. <a href="#" class="cs-switch-to" data-to="num">Switch to #</a>');
        }
        paintCsTable();
        return false;
    });

    function getCsHeader1(class_name) {
        var header1='<th class="text-center bold-border-left '+class_name+'">$</th>';
        header1+='<th class="text-center '+class_name+'">%</th>';
        header1+=getCsTableThCell('num-n1','N#1',class_name);
        header1+=getCsTableThCell('num-n2','N2+',class_name);
        header1+=getCsTableThCell('num-r1','R#1',class_name);
        header1+=getCsTableThCell('num-r2','R2+',class_name);
        return header1+
            '<th class="text-center'+class_name+'">#</th>'+
            '<th class="text-center'+class_name+' bold-border-right">#U</th>';
    }

    function getEmptyRnObj() {
        return {
            n1:{amount:0,count:0},
            n2:{amount:0,count:0},
            r1:{amount:0,count:0},
            r2:{amount:0,count:0},
            u:{amount:0,count:0},
            consultation:{amount:0,count:0},
            others:{amount:0,count:0}
        };
    }

    function getRNdata(data,period) {
        if(data[period]==undefined)
            return getEmptyRnObj();
        else {
            var rn_data=JSON.parse(JSON.stringify(data[period]));
            if(!$('.nums-filter[value="num-n1"]').prop('checked'))
                rn_data['n1']={amount:0,count:0};
            if(!$('.nums-filter[value="num-n2"]').prop('checked'))
                rn_data['n2']={amount:0,count:0};
            if(!$('.nums-filter[value="num-r1"]').prop('checked'))
                rn_data['r1']={amount:0,count:0};
            if(!$('.nums-filter[value="num-r2"]').prop('checked'))
                rn_data['r2']={amount:0,count:0};
            if(!$('.nums-filter[value="other-payments"]').prop('checked'))
                rn_data['others']={amount:0,count:0};
            if(!$('.nums-filter[value="consultation"]').prop('checked'))
                rn_data['consultation']={amount:0,count:0};

            return rn_data;
        }
    }

    function paintCsTable() {
        var header0='<table class="table table-bordered"><thead><tr><th>Client Source</th>';
        var header1='<tr><th></th>';
        var body='';
        var footer='';
        var header_flag=1;
        var data=JSON.parse(JSON.stringify(cs_source_data));
        var colspan=4+$('.nr-chbx:checked').length;
        var header1_template=getCsHeader1('');
        var total_row='<tr><td class="font-weight-bold text-center total">TOTAL</td>';
        var total_rn_data_sum=getEmptyRnObj();
        var data_to=$('.cs-switch-to').data('to');
        var uc_total=0;
        data['periods'].forEach(function (period,p_index) {
            header0 += getCsHeader0(colspan, period,'');
            header1 += header1_template;
            var total_rn_data=getRNdata(data['total_data'],period);
            var total_amount_sum=total_rn_data['n1']['amount']+total_rn_data['n2']['amount']+
                total_rn_data['r1']['amount']+total_rn_data['r2']['amount']+
                total_rn_data['others']['amount']+total_rn_data['consultation']['amount'];

            var total_n_sum=total_rn_data['n1']['count']+total_rn_data['n2']['count']+
                total_rn_data['r1']['count']+total_rn_data['r2']['count'];

            var total_u=total_rn_data['u']['count'];
            uc_total+=total_u;
            total_row+='<td class="text-right bold-border-left total" title="Total '+period+'" style="white-space: nowrap;min-width:115px;">'+
                (Math.abs(total_amount_sum)>0?'<span class="float-left">$</span>'+total_amount_sum.formatMoney(2,'.',','):'<span class="zero">0.00</span>')+
                '</td>';//amount
            total_row+='<td class="text-right total"></td>';//percent
            total_row+=getCsTableTdCell('num-n1',total_rn_data['n1']['count']?total_rn_data['n1']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+=getCsTableTdCell('num-n2',total_rn_data['n2']['count']?total_rn_data['n2']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+=getCsTableTdCell('num-r1',total_rn_data['r1']['count']?total_rn_data['r1']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+=getCsTableTdCell('num-r2',total_rn_data['r2']['count']?total_rn_data['r2']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+='<td class="text-center total" title="Total '+period+'">'+(total_n_sum?total_n_sum:'<span class="zero">0</span>')+'</td>';
            total_row+='<td class="text-center bold-border-right total" title="Unique clients '+period+'">'+(total_u?total_u:'<span class="zero">0</span>')+'</td>';

            total_rn_data_sum['n1']['amount']+=total_rn_data['n1']['amount'];
            total_rn_data_sum['n1']['count']+=total_rn_data['n1']['count'];
            total_rn_data_sum['n2']['amount']+=total_rn_data['n2']['amount'];
            total_rn_data_sum['n2']['count']+=total_rn_data['n2']['count'];

            total_rn_data_sum['r1']['amount']+=total_rn_data['r1']['amount'];
            total_rn_data_sum['r1']['count']+=total_rn_data['r1']['count'];
            total_rn_data_sum['r2']['amount']+=total_rn_data['r2']['amount'];
            total_rn_data_sum['r2']['count']+=total_rn_data['r2']['count'];

            total_rn_data_sum['others']['amount']+=total_rn_data['others']['amount'];
            total_rn_data_sum['others']['count']+=total_rn_data['others']['count'];

            total_rn_data_sum['consultation']['amount']+=total_rn_data['consultation']['amount'];
            total_rn_data_sum['consultation']['count']+=total_rn_data['consultation']['count'];
        });
        var grand_total_amount_sum=total_rn_data_sum['n1']['amount']+total_rn_data_sum['n2']['amount']+
            total_rn_data_sum['r1']['amount']+total_rn_data_sum['r2']['amount']+
            total_rn_data_sum['others']['amount']+total_rn_data_sum['consultation']['amount'];

        var grand_total_n_sum=total_rn_data_sum['n1']['count']+total_rn_data_sum['n2']['count']+
            total_rn_data_sum['r1']['count']+total_rn_data_sum['r2']['count'];

        total_row+='<td class="text-right bold-border-left total" title="Total" style="white-space: nowrap;min-width:115px;">'+
            (Math.abs(grand_total_amount_sum)>0?'<span class="float-left">$</span>'+grand_total_amount_sum.formatMoney(2,'.',','):'<span class="zero">0.00</span>')+
            '</td>';//amount
        total_row+='<td class="text-right total"></td>';//percent
        total_row+=getCsTableTdCell('num-n1',total_rn_data_sum['n1']['count']?total_rn_data_sum['n1']['count']:'<span class="zero">0</span>','Total','total');
        total_row+=getCsTableTdCell('num-n2',total_rn_data_sum['n2']['count']?total_rn_data_sum['n2']['count']:'<span class="zero">0</span>','Total','total');
        total_row+=getCsTableTdCell('num-r1',total_rn_data_sum['r1']['count']?total_rn_data_sum['r1']['count']:'<span class="zero">0</span>','Total','total');
        total_row+=getCsTableTdCell('num-r2',total_rn_data_sum['r2']['count']?total_rn_data_sum['r2']['count']:'<span class="zero">0</span>','Total','total');
        total_row+='<td class="text-center total" title="Total">'+(grand_total_n_sum?grand_total_n_sum:'<span class="zero">0</span>')+'</td>';
        total_row+='<td class="text-center bold-border-right total" title="Total">'+uc_total+'</td>';

        total_row+='</tr>';

        for (let data_key in data['data']) {
            var rn_data_sum=getEmptyRnObj();
            body+='<tr><td class="bold-border-right" style="white-space: nowrap">'+data_key+'</td>';

            data['periods'].forEach(function (period,p_index) {
                var rn_data=getRNdata(data['data'][data_key],period);
                var total_rn_data=getRNdata(data['total_data'],period);
                
                var amount_sum=rn_data['n1']['amount']+rn_data['n2']['amount']+
                    rn_data['r1']['amount']+rn_data['r2']['amount']+
                    rn_data['others']['amount']+rn_data['consultation']['amount'];
                var total_amount_sum=total_rn_data['n1']['amount']+total_rn_data['n2']['amount']+
                    total_rn_data['r1']['amount']+total_rn_data['r2']['amount']+
                    total_rn_data['others']['amount']+total_rn_data['consultation']['amount'];

                var n_sum=rn_data['n1']['count']+rn_data['n2']['count']+rn_data['r1']['count']+rn_data['r2']['count'];
                var total_n_sum=total_rn_data['n1']['count']+total_rn_data['n2']['count']+
                    total_rn_data['r1']['count']+total_rn_data['r2']['count'];

                var percent;
                if(data_to=='num')
                    if(total_amount_sum)
                        percent=parseFloat(100*amount_sum/total_amount_sum).toFixed(2);
                    else
                        percent='N/A';
                else
                    if(total_n_sum)
                        percent=parseFloat(100*n_sum/total_n_sum).toFixed(2);
                    else
                        percent='N/A';
                body+='<td class="text-right bold-border-left" title="'+data_key+' '+period+'" style="white-space: nowrap;min-width:115px;">'+
                    (Math.abs(amount_sum)>0?'<span class="float-left">$</span>'+amount_sum.formatMoney(2,'.',','):'<span class="zero">0</span>')+
                    '</td>';//amount
                body+='<td class="text-right" title="'+data_key+' '+period+'">'+(Math.abs(percent)>0?percent+'%':'<span class="zero">0</span>')+'</td>';//percent



                body+=getCsTableTdCell('num-n1',rn_data['n1']['count']?rn_data['n1']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+=getCsTableTdCell('num-n2',rn_data['n2']['count']?rn_data['n2']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+=getCsTableTdCell('num-r1',rn_data['r1']['count']?rn_data['r1']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+=getCsTableTdCell('num-r2',rn_data['r2']['count']?rn_data['r2']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+='<td class="text-center " title="'+data_key+' '+period+'">'+(n_sum?n_sum:'<span class="zero">0</span>')+'</td>';
                body+='<td class="text-center bold-border-right" title="'+data_key+' '+period+'"><span class="zero">0</span></td>';

                rn_data_sum['n1']['amount']+=rn_data['n1']['amount'];
                rn_data_sum['n1']['count']+=rn_data['n1']['count'];
                rn_data_sum['n2']['amount']+=rn_data['n2']['amount'];
                rn_data_sum['n2']['count']+=rn_data['n2']['count'];

                rn_data_sum['r1']['amount']+=rn_data['r1']['amount'];
                rn_data_sum['r1']['count']+=rn_data['r1']['count'];
                rn_data_sum['r2']['amount']+=rn_data['r2']['amount'];
                rn_data_sum['r2']['count']+=rn_data['r2']['count'];

                rn_data_sum['others']['amount']+=rn_data['others']['amount'];
                rn_data_sum['others']['count']+=rn_data['others']['count'];
                
                rn_data_sum['consultation']['amount']+=rn_data['consultation']['amount'];
                rn_data_sum['consultation']['count']+=rn_data['consultation']['count'];
            });
            var amount_sum=rn_data_sum['n1']['amount']+rn_data_sum['n2']['amount']+
                rn_data_sum['r1']['amount']+rn_data_sum['r2']['amount']+
                rn_data_sum['others']['amount']+rn_data_sum['consultation']['amount'];
            var n_sum=rn_data_sum['n1']['count']+rn_data_sum['n2']['count']+rn_data_sum['r1']['count']+rn_data_sum['r2']['count'];

            body+='<td class="text-right bold-border-left total" title="Total '+data_key+'" style="white-space: nowrap;min-width:115px;">'+
                (Math.abs(amount_sum)>0?'<span class="float-left">$</span>'+amount_sum.formatMoney(2,'.',','):'<span class="zero">0.00</span>')+
                '</td>';//amount

            var percent;
            if(data_to=='num') {
                if(grand_total_amount_sum)
                    percent = parseFloat(100 * amount_sum / grand_total_amount_sum).toFixed(2);
                else
                    percent='N/A';
            }else {
                if(grand_total_n_sum)
                    percent = parseFloat(100 * n_sum / grand_total_n_sum).toFixed(2);
                else
                    percent='N/A';
            }

            body+='<td class="text-right total">'+(Math.abs(percent)>0?percent+'%':'<span class="zero">0</span>')+'</td>';//percent



            body+=getCsTableTdCell('num-n1',rn_data_sum['n1']['count']?rn_data_sum['n1']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+=getCsTableTdCell('num-n2',rn_data_sum['n2']['count']?rn_data_sum['n2']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+=getCsTableTdCell('num-r1',rn_data_sum['r1']['count']?rn_data_sum['r1']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+=getCsTableTdCell('num-r2',rn_data_sum['r2']['count']?rn_data_sum['r2']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+='<td class="text-center  total" title="Total '+data_key+'">'+(n_sum?n_sum:'<span class="zero">0</span>')+'</td>';
            body+='<td class="text-center bold-border-right total" title="Total '+data_key+'"><span class="zero">0</span></td>';

            body+='</tr>';
            header_flag=0;
        }
        body+=total_row;
        header0+=getCsHeader0(colspan,'TOTAL','total');
        header1+=getCsHeader1('total');
        header0+='</tr>';
        header1+='</tr></thead>';
        body+='</tr>';
        var table=header0+header1+body+footer+'</table>';
        $('#cs-content').html(table);
    }

    var current_row_el;
    $('body').on('dblclick','.raw-revenues-row',function () {
        current_row_el=$(this);
        var client_type_id=$(this).data('client-type');
        var pay_type_id=$(this).data('pay-type');
        var client_source_id=$(this).data('client-source');
        var boom_source_id=$(this).data('boom-source');

        $('#date-caption').text($.trim($(this).find('td:eq(0)').text()));
        $('#amount-caption').text('$'+$.trim($(this).find('td:eq(1) span:eq(1)').text()));
        $('#client-caption').text($.trim($(this).find('td:eq(2)').text()));

        $('#client-type-select').val(client_type_id);
        $('#pay-type-select').val(pay_type_id);
        $('#client-source-select').val(client_source_id);
        $('#boom-source-select').val(boom_source_id);
        $('#ert-save-btn').data('id',$(this).data('id'));

        $('#edit-rr-types-modal').modal('show');
    });

    $('#ert-save-btn').click(function () {
        $('#edit-rr-types-modal').modal('hide');
        $('#tmfwaiting400_modal').modal('show');
        $.post(
            '/tmf-revenue-breakdown/save-rr-types',
            {
                id:$(this).data('id'),
                client_type_id:$('#client-type-select').val(),
                pay_type_id:$('#pay-type-select').val(),
                client_source_id:$('#client-source-select').val(),
                boom_source_id:$('#boom-source-select').val()
            },
            function (msg) {
                setTimeout(function () {
                    $('#tmfwaiting400_modal').modal('hide');
                },500);
                if(msg.length){
                    $('.toast-body').html(msg);
                    current_row_el.data('client-type',$('#client-type-select').val());
                    current_row_el.find('td:eq(3)').text($('#client-type-select option:selected').text());
                    current_row_el.data('pay-type',$('#pay-type-select').val());
                    current_row_el.find('td:eq(4)').text($('#pay-type-select option:selected').text());
                    current_row_el.data('boom-source',$('#boom-source-select').val());
                    current_row_el.find('td:eq(6)').text($('#boom-source-select option:selected').text());
                    var client_id=current_row_el.data('client');
                    $('.raw-revenues-row[data-client="'+client_id+'"]').each(function () {
                        $(this).data('client-source',$('#client-source-select').val());
                        $(this).find('td:eq(5)').text($('#client-source-select option:selected').text());
                    });
                }else{
                    $('.toast-body').html('<span class="text-danger">Unknown error during saving types!</span>');
                    setTimeout(function () {
                        $('#edit-rr-types-modal').modal('show');
                    },600);
                }
                $('.toast').toast('show');
            }
        );
    });



</script>