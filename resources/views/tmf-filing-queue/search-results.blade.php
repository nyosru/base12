@if(count($data))
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Mark</th>
                <th class="text-center"><img src="http://mincovlaw.com/images/icons/cipo_uspto.jpg" style="width: 20px;height: 12px;"></th>
                <th class="text-center">Client</th>
                <th class="text-center">Status</th>
                <th class="text-center"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $el)
            @php
                $show=0;
                if($el['current-status'] || (!$el['current-status'] && $show_not_in_queue)){
                    $show=1;
                    if($el['current-status']){
                        if(in_array($el['current-status']->id,$done_ids)){
                            if($el['dashboard']->formalized_status_modified_at>=$datetime_xd)
                                $show=1;
                            else
                                $show=0;
                        }
                    }
                }
            @endphp
            @if($show)
            <tr>
                <td class="text-center" style="height: 100px;padding: 0.32rem">
                    <div style="background: white;border:1px solid #565656;border-radius: 5px;height: 100%;">
                        <table style="height: 100%;width: 100%;border: none">
                            <tr>
                                <td style="text-align: center;vertical-align: middle;border: none">
                                    <strong>{!! $el['mark'] !!}</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td class="text-center align-middle" title="{{$el['country']}}">{!! $el['flag'] !!} <span style="opacity: 0;position: absolute;left: 0;">{{$el['country']}}</span></td>
                <td class="text-center align-middle">{{$el['client']}}</td>
                <td class="text-center align-middle">{{($el['current-status']?$el['current-status']->name:'N/A')}}</td>
                <td class="text-center align-middle">
                    @if($el['current-status'])
                            <button class="btn btn-sm btn-info search-open-btn"
                                    data-dashboard-id="{{$el['dashboard']->id}}"
                                    data-id="{{$el['current-status']->id}}"
                            data-root-id="{{$el['current-status']->tmf_filing_queue_root_status_id}}">
                                OPEN
                            </button>
                    @endif
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center">No Results</div>
    @endif