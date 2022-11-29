<!--<table class="table table-bordered" >
    <thead>
    <tr>
        <th class="text-center">Pay Type</th>
        <th colspan="7" class="text-center">Total</th>
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
<div class="d-table" style="width: 100%">
    <div class="d-table-cell" id="cs-left-column">
        <table class="table table-bordered" >
            <thead>
            <tr>
                <th class="text-center">Client Source</th>
            </tr>
            <tr>
                <th><span style="color: transparent">$</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($client_sources as $client_source)
                <tr>
                    <td class="text-left cs-left-column-cell">{{$client_source->name}}</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-left font-weight-bold">TOTAL</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="d-table-cell overflow-auto" id="cs-middle-column">
        <div style="width: 100px;">
            <table class="table table-bordered months-table">
                <thead>
                <tr>
                    <th class="text-center client-source-cell">Client Source</th>
                    <th colspan="7"
                        class="text-center">{!! implode('</th><th colspan="7" class="text-center">',$table_th) !!}</th>
                    <th class="text-center client-source-total-cell" colspan="7">Total</th>
                </tr>
                <tr>
                    <th class="text-center client-source-cell"></th>
                    @foreach($table_th as $el)
                        <th class="text-center amount">$</th>
                        <th class="text-center">%</th>
                        <th class="text-center num-n1">N#1</th>
                        <th class="text-center num-n2">N2+</th>
                        <th class="text-center num-r1">R#1</th>
                        <th class="text-center num-r2">R2+</th>
                        <th class="text-center num">#</th>
                    @endforeach
                    <th class="text-center client-source-total-cell amount">$</th>
                    <th class="text-center client-source-total-cell">%</th>
                    <th class="text-center client-source-total-cell num-n1">N#1</th>
                    <th class="text-center client-source-total-cell num-n2">N2+</th>
                    <th class="text-center client-source-total-cell num-r1">R#1</th>
                    <th class="text-center client-source-total-cell num-r2">R2+</th>
                    <th class="text-center client-source-total-cell num">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($client_sources as $client_source)
                    <tr>
                        <td class="text-left client-source-cell">{{$client_source->name}}</td>
                        @foreach($table_th as $m_index)

                            <td class="text-right amount" style="white-space: nowrap" data-amount="{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['amount']:0}}">
                                <span class="float-left">$</span> {{isset($data[$client_source->name][$m_index])?number_format($data[$client_source->name][$m_index]['amount'],2):0.00}}</td>
                            <td class="text-right amount-percent">
                                @if(isset($data[$client_source->name][$m_index]) && $data[$client_source->name][$m_index]['amount']>0)
                                    @if($data['total'][$m_index])
                                        {{number_format(100*$data[$client_source->name][$m_index]['amount']/$data['total'][$m_index]['amount'],2)}}%
                                    @else
                                        N/A
                                    @endif
                                @else
                                    0%
                                @endif
                            </td>
                            <td class="text-right num-percent">
                                @if(isset($data[$client_source->name][$m_index]) && $data[$client_source->name][$m_index]['num']>0)
                                    @if($data['total'][$m_index])
                                        {{number_format(100*$data[$client_source->name][$m_index]['num']/$data['total'][$m_index]['num'],2)}}%
                                    @else
                                        N/A
                                    @endif
                                @else
                                    0%
                                @endif
                            </td>
                            <td class="text-center num-n1" data-amount="{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['amount-n#1']:0}}">{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['n#1']:0}}</td>
                            <td class="text-center num-n2" data-amount="{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['amount-n2+']:0}}">{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['n2+']:0}}</td>
                            <td class="text-center num-r1" data-amount="{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['amount-r#1']:0}}">{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['r#1']:0}}</td>
                            <td class="text-center num-r2" data-amount="{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['amount-r2+']:0}}">{{isset($data[$client_source->name][$m_index])?$data[$client_source->name][$m_index]['r2+']:0}}</td>
                            <td class="text-center num"></td>
                        @endforeach
                        <td class="text-center client-source-total-cell amount"></td>
                        <td class="text-center client-source-total-cell"></td>
                        <td class="text-center client-source-total-cell num-n1"></td>
                        <td class="text-center client-source-total-cell num-n2"></td>
                        <td class="text-center client-source-total-cell num-r1"></td>
                        <td class="text-center client-source-total-cell num-r2"></td>
                        <td class="text-center client-source-total-cell num"></td>
                    </tr>
                @endforeach
                <tr>
                    <td class="client-source-cell font-weight-bold text-left">TOTAL</td>
                @foreach($table_th as $m_index)
                        <td class="text-right total amount font-weight-bold" style="white-space: nowrap" data-amount="{{$data['total'][$m_index]['amount']}}"><span
                                    class="float-left">$</span> {{number_format($data['total'][$m_index]['amount'],2)}}</td>
                        <td></td>
                        <td class="text-center total num-n1" data-amount="{{isset($data['total'][$m_index])?$data['total'][$m_index]['amount-n#1']:0}}">{{isset($data['total'][$m_index])?$data['total'][$m_index]['n#1']:0}}</td>
                        <td class="text-center total num-n2" data-amount="{{isset($data['total'][$m_index])?$data['total'][$m_index]['amount-n2+']:0}}">{{isset($data['total'][$m_index])?$data['total'][$m_index]['n2+']:0}}</td>
                        <td class="text-center total num-r1" data-amount="{{isset($data['total'][$m_index])?$data['total'][$m_index]['amount-r#1']:0}}">{{isset($data['total'][$m_index])?$data['total'][$m_index]['r#1']:0}}</td>
                        <td class="text-center total num-r2" data-amount="{{isset($data['total'][$m_index])?$data['total'][$m_index]['amount-r2+']:0}}">{{isset($data['total'][$m_index])?$data['total'][$m_index]['r2+']:0}}</td>
                        <td class="text-center total num"></td>
                @endforeach
                    <td class="text-center client-source-total-cell amount"></td>
                    <td class="text-center client-source-total-cell"></td>
                    <td class="text-center client-source-total-cell num-n1"></td>
                    <td class="text-center client-source-total-cell num-n2"></td>
                    <td class="text-center client-source-total-cell num-r1"></td>
                    <td class="text-center client-source-total-cell num-r2"></td>
                    <td class="text-center client-source-total-cell num"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-table-cell" id="cs-right-column">
        <table class="table table-bordered" >
            <thead>
            <tr>
                <th colspan="7" class="text-center">Total</th>
            </tr>
            <tr>
                <th class="text-center amount">$</th>
                <th class="text-center">%</th>
                <th class="text-center num-n1">N#1</th>
                <th class="text-center num-n2">N2+</th>
                <th class="text-center num-r1">R#1</th>
                <th class="text-center num-r2">R2+</th>
                <th class="text-center num-r2">#</th>
            </tr>
            </thead>
            <tbody>
            @foreach($client_sources as $client_source)
                <tr>
                    <td class="text-right total-final amount font-weight-bold" style="white-space: nowrap" data-amount="{{isset($total_rows[$client_source->name])?$total_rows[$client_source->name]:0}}"><span class="float-left">$</span> {{isset($total_rows[$client_source->name])?number_format($total_rows[$client_source->name],2):0}}</td>
                    <td class="text-right num-percent">{{isset($total_rows_n[$client_source->name])?number_format(100*$total_rows_n[$client_source->name]/$total_amount_n,2):0}}%</td>
                    <td class="text-right total-final amount-percent">{{isset($total_rows[$client_source->name])?number_format(100*$total_rows[$client_source->name]/$total_amount,2):0}}%</td>
                    <td class="text-center total-final num-n1"></td>
                    <td class="text-center total-final num-n2"></td>
                    <td class="text-center total-final num-r1"></td>
                    <td class="text-center total-final num-r2"></td>
                    <td class="text-center total-final num"></td>
                </tr>
            @endforeach
            <tr>
                <td class="text-right total total-final amount font-weight-bold" style="white-space: nowrap" data-amount="{{$total_amount}}"><span class="float-left">$</span> {{number_format($total_amount,2)}}</td>
                <td></td>
                <td class="text-center total total-final num-n1"></td>
                <td class="text-center total total-final num-n2"></td>
                <td class="text-center total total-final num-r1"></td>
                <td class="text-center total total-final num-r2"></td>
                <td class="text-center total total-final num"></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
