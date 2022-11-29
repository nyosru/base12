<!--<table class="table table-bordered" id="pay-type-table">
    <thead>
    <tr>
        <th class="text-center">Pay Type</th>
        <th colspan="2" class="text-center">Total</th>
    </tr>
    <tr>
        <th></th>
        <th class="text-center num">#</th>
        <th class="text-center amount">$</th>
        <th class="text-center">%</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>-->
<div>
    <div class="d-inline-block float-left" style="width: 105px">
        <table class="table table-bordered" id="pay-type-table">
            <thead>
            <tr>
                <th class="text-center">Pay Type</th>
            </tr>
            <tr>
                <th><span style="color: transparent">$</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($pay_types as $pay_type)
                <tr>
                    <td class="text-center">{{$pay_type->name}}</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center font-weight-bold">TOTAL</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="d-inline-block float-left overflow-auto" style="width: 750px;">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="2"
                    class="text-center">{!! implode('</th><th colspan="2" class="text-center">',$table_th) !!}</th>
            </tr>
            <tr>
                @foreach($table_th as $el)
                    <th class="text-center num">#</th>
                    <th class="text-center amount">$</th>
                    <th class="text-center">%</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($pay_types as $pay_type)
                <tr>
                    @foreach($table_th as $m_index)

                        <td class="text-center num">{{isset($data[$pay_type->name][$m_index])?$data[$pay_type->name][$m_index]['num']:0}}</td>
                        <td class="text-right num-percent">
                            @if(isset($data[$pay_type->name][$m_index]) && $data[$pay_type->name][$m_index]['num']>0)
                                @if($data['total'][$m_index])
                                    {{number_format(100*$data[$pay_type->name][$m_index]['num']/$data['total'][$m_index]['num'],2)}}%
                                @else
                                    N/A
                                @endif
                            @else
                                0%
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            <tr>
            @foreach($table_th as $m_index)
                    <td class="text-center num font-weight-bold">{{$data['total'][$m_index]['num']}}</td>
                    <td></td>
            @endforeach
            </tr>
            </tbody>
        </table>
    </div>
    <div class="d-inline-block float-left" style="width: 180px">
        <table class="table table-bordered" id="pay-type-table">
            <thead>
            <tr>
                <th colspan="2" class="text-center">Total</th>
            </tr>
            <tr>
                <th class="text-center num">#</th>
                <th class="text-center">%</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pay_types as $pay_type)
                <tr>
                    <td class="text-center num">{{isset($total_rows_n[$pay_type->name])?$total_rows_n[$pay_type->name]:0}}</td>
                    <td class="text-right num-percent">{{isset($total_rows_n[$pay_type->name])?number_format(100*$total_rows_n[$pay_type->name]/$total_amount_n,2):0}}%</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center num font-weight-bold">{{$total_amount_n}}</td>
                <td></td>
            </tr>

            </tbody>
        </table>
    </div>
</div>
