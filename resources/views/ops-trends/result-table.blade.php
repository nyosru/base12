<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">Status</th>
            <th class="text-center">#</th>
            <th class="text-center">Avg. Days</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $el)
            <tr>
                <td class="text-left" {!! $el['border-top']?'style="border-top:2px solid black;"':''!!}>{!!  $el['caption'] !!}</td>
                <td class="text-center font-{{$el['font-style']}}" {!! $el['border-top']?'style="border-top:2px solid black;"':''!!}>{{$el['status-info']->getNumber()}}</td>
                <td class="text-center font-{{$el['font-style']}}" {!! $el['border-top']?'style="border-top:2px solid black;"':''!!}><a href="#" class="show-details" data-ids="{{json_encode($el['status-info']->getIds())}}">{{$el['status-info']->getAverageDays()}}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>