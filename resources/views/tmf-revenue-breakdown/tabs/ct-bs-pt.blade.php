<div class="overflow-auto">

    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center">{{$type_caption}}</th>
            <th colspan="3"
                class="text-center bold-border-left bold-border-right">{!! implode('</th><th colspan="3" class="text-center bold-border-left bold-border-right">',$table_th) !!}</th>
            <th colspan="3" class="text-center bold-border-left bold-border-right total">Total</th>
        </tr>
        <tr>
            <th></th>
            @foreach($table_th as $el)
                <th class="text-center bold-border-left num">#</th>
                <th class="text-center amount">$</th>
                <th class="text-center bold-border-right">%</th>
            @endforeach
            <th class="text-center num bold-border-left total">#</th>
            <th class="text-center amount total">$</th>
            <th class="text-center bold-border-right total">%</th>
        </tr>
        </thead>
        <tbody>
        @foreach($types as $type)
            <tr>
                <td class="text-center">{{$type->name}}</td>
                @foreach($table_th as $m_index)

                    <td class="text-center num bold-border-left" title="{{$type->name}}">{!! isset($data[$type->name][$m_index])?($data[$type->name][$m_index]['num']?$data[$type->name][$m_index]['num']:'<span class="zero">0</span>'):'<span class="zero">0</span>' !!}</td>
                    <td class="text-right amount" style="white-space: nowrap"  title="{{$type->name}}">
                        {!! isset($data[$type->name][$m_index])?(abs($data[$type->name][$m_index]['amount'])>0?'<span class="float-left">$</span>'.number_format($data[$type->name][$m_index]['amount'],2):'<span class="zero">0.00</span>'):'<span class="zero">0.00</span>' !!}
                    </td>
                    <td class="text-right amount-percent bold-border-right"  title="{{$type->name}}">
                        @if(isset($data[$type->name][$m_index]) && $data[$type->name][$m_index]['amount']>0)
                            @if($data['total'][$m_index])
                                @if(abs($data[$type->name][$m_index]['amount'])>0)
                                    {{number_format(100*$data[$type->name][$m_index]['amount']/$data['total'][$m_index]['amount'],2)}}%
                                @else
                                    <span class="zero">0%</span>
                                @endif
                            @else
                                <span class="zero">N/A</span>
                            @endif
                        @else
                            <span class="zero">0%</span>
                        @endif
                    </td>
                    <td class="text-right num-percent bold-border-right" title="{{$type->name}}">
                        @if(isset($data[$type->name][$m_index]) && $data[$type->name][$m_index]['num']>0)
                            @if($data['total'][$m_index])
                                @if($data[$type->name][$m_index]['num'])
                                    {{number_format(100*$data[$type->name][$m_index]['num']/$data['total'][$m_index]['num'],2)}}%
                                @else
                                    <span class="zero">0%</span>
                                @endif
                            @else
                                <span class="zero">N/A</span>
                            @endif
                        @else
                            <span class="zero">0%</span>
                        @endif
                    </td>
                @endforeach
                <td class="text-center num bold-border-left total"  title="{{$type->name}}">{!! isset($total_rows_n[$type->name])?($total_rows_n[$type->name]?$total_rows_n[$type->name]:'<span class="zero">0</span>'):'<span class="zero">0</span>'!!}</td>
                <td class="text-right amount font-weight-bold total"  title="{{$type->name}}" style="white-space: nowrap">
                    {!! isset($total_rows[$type->name])?(abs($total_rows[$type->name])>0?'<span class="float-left">$</span>'.number_format($total_rows[$type->name],2):'<span class="zero">0</span>'):'<span class="zero">0</span>'!!}
                </td>
                <td class="text-right num-percent bold-border-right total"  title="{{$type->name}}">{!! isset($total_rows_n[$type->name])?(abs($total_rows_n[$type->name])>0?number_format(100*$total_rows_n[$type->name]/$total_amount_n,2):'<span class="zero">0</span>'):'<span class="zero">0</span>'!!}
                    %
                </td>
                <td class="text-right amount-percent bold-border-right total" title="{{$type->name}}">{!! isset($total_rows[$type->name])?(abs($total_rows[$type->name])>0?number_format(100*$total_rows[$type->name]/$total_amount,2):'<span class="zero">0</span>'):'<span class="zero">0</span>'!!}
                    %
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="text-center font-weight-bold total">TOTAL</td>
            @foreach($table_th as $m_index)
                <td class="text-center num font-weight-bold bold-border-left total">{!! ($data['total'][$m_index]['num']?$data['total'][$m_index]['num']:'<span class="zero">0</span>') !!}</td>
                <td class="text-right amount font-weight-bold total" style="white-space: nowrap">{!! (abs($data['total'][$m_index]['amount'])>0?'<span class="float-left">$</span>'.number_format($data['total'][$m_index]['amount'],2):'<span class="zero">0</span>') !!}</td>
                <td class="bold-border-right total"></td>
            @endforeach
            <td class="text-center num font-weight-bold bold-border-left total">{!! (abs($total_amount_n)>0?$total_amount_n:'<span class="zero">0</span>') !!}</td>
            <td class="text-right amount font-weight-bold total" style="white-space: nowrap"><span
                        class="float-left">$</span> {!! (abs($total_amount)>0?number_format($total_amount,2):'<span class="zero">0</span>') !!}</td>
            <td class="bold-border-right total"></td>
        </tr>
        </tbody>
    </table>
</div>
