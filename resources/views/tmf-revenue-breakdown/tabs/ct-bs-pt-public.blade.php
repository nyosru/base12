<div class="overflow-auto">

    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center">{{$type_caption}}</th>
            <th colspan="2"
                class="text-center bold-border-left bold-border-right">{!! implode('</th><th colspan="2" class="text-center bold-border-left bold-border-right">',$table_th) !!}</th>
            <th colspan="2" class="text-center bold-border-left bold-border-right total">Total</th>
        </tr>
        <tr>
            <th></th>
            @foreach($table_th as $el)
                <th class="text-center bold-border-left num">#</th>
                <th class="text-center bold-border-right">%</th>
            @endforeach
            <th class="text-center num bold-border-left total">#</th>
            <th class="text-center bold-border-right total">%</th>
        </tr>
        </thead>
        <tbody>
        @foreach($types as $type)
            <tr>
                <td class="text-center">{{$type->name}}</td>
                @foreach($table_th as $m_index)

                    <td class="text-center num bold-border-left" title="{{$type->name}}">{!! isset($data[$type->name][$m_index])?($data[$type->name][$m_index]['num']?$data[$type->name][$m_index]['num']:'<span class="zero">0</span>'):'<span class="zero">0</span>' !!}</td>
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
                <td class="text-right num-percent bold-border-right total"  title="{{$type->name}}">{!! isset($total_rows_n[$type->name])?(abs($total_rows_n[$type->name])>0?number_format(100*$total_rows_n[$type->name]/$total_amount_n,2):'<span class="zero">0</span>'):'<span class="zero">0</span>'!!}
                    %
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="text-center font-weight-bold total">TOTAL</td>
            @foreach($table_th as $m_index)
                <td class="text-center num font-weight-bold bold-border-left total">{!! ($data['total'][$m_index]['num']?$data['total'][$m_index]['num']:'<span class="zero">0</span>') !!}</td>
                <td class="bold-border-right total"></td>
            @endforeach
            <td class="text-center num font-weight-bold bold-border-left total">{!! (abs($total_amount_n)>0?$total_amount_n:'<span class="zero">0</span>') !!}</td>
            <td class="bold-border-right total"></td>
        </tr>
        </tbody>
    </table>
</div>
