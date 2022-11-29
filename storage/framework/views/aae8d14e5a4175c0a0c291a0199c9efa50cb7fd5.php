<script type="text/javascript">

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
            var current_client=$.trim($(this).find('td:eq(1)').text());
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
        paintFilter('.pay-type-filter-chbx','pay-type-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(3)');
        paintFilter('.client-type-filter-chbx','client-type-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(2)');
        paintFilter('.client-source-filter-chbx','client-source-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(4)');
        paintFilter('.boom-source-filter-chbx','boom-source-filter-modal','#raw-revenues-table thead tr:eq(1) th:eq(5)');
    }

    function getCsHeader1(class_name) {
        var header1='';
        header1+='<th class="text-center bold-border-left '+class_name+'">%</th>';
        header1+=getCsTableThCell('num-n1','N#1',class_name);
        header1+=getCsTableThCell('num-n2','N2+',class_name);
        header1+=getCsTableThCell('num-r1','R#1',class_name);
        header1+=getCsTableThCell('num-r2','R2+',class_name);
        return header1+'<th class="text-center bold-border-right '+class_name+'">#</th>';
    }


    function getEmptyRnObj() {
        return {
            n1:{count:0},
            n2:{count:0},
            r1:{count:0},
            r2:{count:0},
            consultation:{count:0},
            others:{count:0}
        };
    }

    function getRNdata(data,period) {
        if(data[period]==undefined)
            return getEmptyRnObj();
        else {
            var rn_data=JSON.parse(JSON.stringify(data[period]));
            if(!$('.nums-filter[value="num-n1"]').prop('checked'))
                rn_data['n1']={count:0};
            if(!$('.nums-filter[value="num-n2"]').prop('checked'))
                rn_data['n2']={count:0};
            if(!$('.nums-filter[value="num-r1"]').prop('checked'))
                rn_data['r1']={count:0};
            if(!$('.nums-filter[value="num-r2"]').prop('checked'))
                rn_data['r2']={count:0};
            if(!$('.nums-filter[value="other-payments"]').prop('checked'))
                rn_data['others']={count:0};
            if(!$('.nums-filter[value="consultation"]').prop('checked'))
                rn_data['consultation']={count:0};

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
        var colspan=2+$('.nr-chbx:checked').length;
        var header1_template=getCsHeader1('');
        var total_row='<tr><td class="font-weight-bold text-center total">TOTAL</td>';
        var total_rn_data_sum=getEmptyRnObj();
        var data_to=$('.cs-switch-to').data('to');
        data['periods'].forEach(function (period,p_index) {
            header0 += getCsHeader0(colspan, period);
            header1 += header1_template;
            var total_rn_data=getRNdata(data['total_data'],period);

            var total_n_sum=total_rn_data['n1']['count']+total_rn_data['n2']['count']+
                total_rn_data['r1']['count']+total_rn_data['r2']['count'];

            total_row+='<td class="text-right total"></td>';//percent
            total_row+=getCsTableTdCell('num-n1',total_rn_data['n1']['count']?total_rn_data['n1']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+=getCsTableTdCell('num-n2',total_rn_data['n2']['count']?total_rn_data['n2']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+=getCsTableTdCell('num-r1',total_rn_data['r1']['count']?total_rn_data['r1']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+=getCsTableTdCell('num-r2',total_rn_data['r2']['count']?total_rn_data['r2']['count']:'<span class="zero">0</span>','Total '+period,'total');
            total_row+='<td class="text-center bold-border-right total" title="Total '+period+'">'+(total_n_sum?total_n_sum:'<span class="zero">0</span>')+'</td>';

            total_rn_data_sum['n1']['count']+=total_rn_data['n1']['count'];
            total_rn_data_sum['n2']['count']+=total_rn_data['n2']['count'];

            total_rn_data_sum['r1']['count']+=total_rn_data['r1']['count'];
            total_rn_data_sum['r2']['count']+=total_rn_data['r2']['count'];

            total_rn_data_sum['others']['count']+=total_rn_data['others']['count'];

            total_rn_data_sum['consultation']['count']+=total_rn_data['consultation']['count'];
        });

        var grand_total_n_sum=total_rn_data_sum['n1']['count']+total_rn_data_sum['n2']['count']+
            total_rn_data_sum['r1']['count']+total_rn_data_sum['r2']['count'];

        total_row+='<td class="text-right total"></td>';//percent
        total_row+=getCsTableTdCell('num-n1',total_rn_data_sum['n1']['count']?total_rn_data_sum['n1']['count']:'<span class="zero">0</span>','Total','total');
        total_row+=getCsTableTdCell('num-n2',total_rn_data_sum['n2']['count']?total_rn_data_sum['n2']['count']:'<span class="zero">0</span>','Total','total');
        total_row+=getCsTableTdCell('num-r1',total_rn_data_sum['r1']['count']?total_rn_data_sum['r1']['count']:'<span class="zero">0</span>','Total','total');
        total_row+=getCsTableTdCell('num-r2',total_rn_data_sum['r2']['count']?total_rn_data_sum['r2']['count']:'<span class="zero">0</span>','Total','total');
        total_row+='<td class="text-center bold-border-right total" title="Total">'+(grand_total_n_sum?grand_total_n_sum:'<span class="zero">0</span>')+'</td>';

        total_row+='</tr>';

        for (let data_key in data['data']) {
            var rn_data_sum=getEmptyRnObj();
            body+='<tr><td class="bold-border-right" style="white-space: nowrap">'+data_key+'</td>';

            data['periods'].forEach(function (period,p_index) {
                var rn_data=getRNdata(data['data'][data_key],period);
                var total_rn_data=getRNdata(data['total_data'],period);


                var n_sum=rn_data['n1']['count']+rn_data['n2']['count']+rn_data['r1']['count']+rn_data['r2']['count'];
                var total_n_sum=total_rn_data['n1']['count']+total_rn_data['n2']['count']+
                    total_rn_data['r1']['count']+total_rn_data['r2']['count'];

                var percent;
                if(total_n_sum)
                    percent=parseFloat(100*n_sum/total_n_sum).toFixed(2);
                else
                    percent='N/A';
                body+='<td class="text-right" title="'+data_key+' '+period+'">'+(Math.abs(percent)>0?percent+'%':'<span class="zero">0</span>')+'</td>';//percent

                body+=getCsTableTdCell('num-n1',rn_data['n1']['count']?rn_data['n1']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+=getCsTableTdCell('num-n2',rn_data['n2']['count']?rn_data['n2']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+=getCsTableTdCell('num-r1',rn_data['r1']['count']?rn_data['r1']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+=getCsTableTdCell('num-r2',rn_data['r2']['count']?rn_data['r2']['count']:'<span class="zero">0</span>',data_key+' '+period,'');
                body+='<td class="text-center bold-border-right" title="'+data_key+' '+period+'">'+(n_sum?n_sum:'<span class="zero">0</span>')+'</td>';

                rn_data_sum['n1']['count']+=rn_data['n1']['count'];
                rn_data_sum['n2']['count']+=rn_data['n2']['count'];

                rn_data_sum['r1']['count']+=rn_data['r1']['count'];
                rn_data_sum['r2']['count']+=rn_data['r2']['count'];

                rn_data_sum['others']['count']+=rn_data['others']['count'];

                rn_data_sum['consultation']['count']+=rn_data['consultation']['count'];
            });
            var n_sum=rn_data_sum['n1']['count']+rn_data_sum['n2']['count']+rn_data_sum['r1']['count']+rn_data_sum['r2']['count'];


            var percent;
                if(grand_total_n_sum)
                    percent = parseFloat(100 * n_sum / grand_total_n_sum).toFixed(2);
                else
                    percent='N/A';

            body+='<td class="text-right total">'+(Math.abs(percent)>0?percent+'%':'<span class="zero">0</span>')+'</td>';//percent



            body+=getCsTableTdCell('num-n1',rn_data_sum['n1']['count']?rn_data_sum['n1']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+=getCsTableTdCell('num-n2',rn_data_sum['n2']['count']?rn_data_sum['n2']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+=getCsTableTdCell('num-r1',rn_data_sum['r1']['count']?rn_data_sum['r1']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+=getCsTableTdCell('num-r2',rn_data_sum['r2']['count']?rn_data_sum['r2']['count']:'<span class="zero">0</span>','Total '+data_key,'total');
            body+='<td class="text-center bold-border-right total" title="Total '+data_key+'">'+(n_sum?n_sum:'<span class="zero">0</span>')+'</td>';

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

    
</script><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-revenue-breakdown/js-public.blade.php ENDPATH**/ ?>