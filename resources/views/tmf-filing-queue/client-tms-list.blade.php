@foreach($data as $client=>$data_val)
    @php
        $result=[
            'badge-success'=>0,
            'badge-warning'=>0,
            'badge-danger'=>0
        ];

        foreach($data_val as $el){
                if ($tmf_filing_queue_status->deadline_warning_hours > 0 && $tmf_filing_queue_status->deadline_overdue_hours > 0) {
                    $index='badge-success';
                    if (($el['pending_in_this_status_delta'] > $tmf_filing_queue_status->deadline_warning_hours * 3600) &&
                        ($el['pending_in_this_status_delta'] < $tmf_filing_queue_status->deadline_overdue_hours * 3600))
                        $index = 'badge-warning';
                    elseif ($el['pending_in_this_status_delta'] > $tmf_filing_queue_status->deadline_overdue_hours * 3600)
                        $index = 'badge-danger';
                    $result[$index]++;
                }
        }
    @endphp
    <div class="accordion" id="client-tms-block">
        <div class="card">
            <div class="card-header" id="client-tms-block-{{$loop->index}}">
                <h2 class="mb-0">
                    <button class="d-flex align-items-center btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$loop->index}}" aria-expanded="false" aria-controls="collapse-{{$loop->index}}">
                        <div class="flex-grow-1 mr-2">
                            {{$client}} [{{count($data_val)}}]
                        </div>
                        <div class="flex-shrink-1">
                        @foreach($result as $key=>$val)
                            @if($val)
                                    <span class="badge {{$key}} ml-1">{{$val}}</span>
                            @endif
                        @endforeach
                        </div>
                    </button>
                </h2>
            </div>
            <div id="collapse-{{$loop->index}}" class="collapse" aria-labelledby="client-tms-block-{{$loop->index}}" data-parent="#client-tms-block">
                <div class="card-body">
                    <table class="table table-bordered item-table" id="item-table-{{$loop->index}}" style="border-collapse: collapse !important;width: 100%">
                        <thead>
                        <tr>
                            <th class="text-left">Trademark</th>
                            <th class="text-center"><img src="http://mincovlaw.com/images/icons/cipo_uspto.jpg" style="width: 20px;height: 12px;"></th>
                            <th class="text-center">🏁</th>
                            <th class="text-center">Time since</th>
                            <th class="text-center">Pending in<br/>this status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data_val as $el)
                            <tr class="item-row sub-status-tm"
                                data-dashboard-id="{{$el['dashboard']->id}}"
                                data-tmoffer-login="{{($el['tmoffer']?$el['tmoffer']->Login:'')}}"
                                data-tmoffer-id="{{($el['tmoffer']?$el['tmoffer']->ID:'')}}"
                                @if(in_array(\Illuminate\Support\Facades\Auth::user()->ID,[1]))
                                data-addy-note="{{($el['tmoffer']?\App\classes\ThankYouCardSentTextGetter::run($el['tmoffer']->ID):'[]')}}"
                                @endif
                                data-trigger="{{$el['time_since_caption']}}"
                            >
                                <td class="text-center
            @if($tmf_filing_queue_status->deadline_warning_hours>0 && $tmf_filing_queue_status->deadline_overdue_hours>0)
                                {{(($el['pending_in_this_status_delta']>$tmf_filing_queue_status->deadline_warning_hours*3600) && ($el['pending_in_this_status_delta']<$tmf_filing_queue_status->deadline_overdue_hours*3600))?'bg-warning':''}}
                                {{($el['pending_in_this_status_delta']>$tmf_filing_queue_status->deadline_overdue_hours*3600)?'bg-danger':''}}
                                @endif" style="height: 100px;padding: 0.32rem">
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
                                <td class="text-center align-middle" style="white-space: nowrap" @if(strlen($el['boom_when_by'])) title="{{$el['boom_when_by']}}" @endif>{!! $el['time_since_caption_icon'] !!}<span style="position: absolute;opacity: 0">{!!strlen($el['time_since_caption'])?$el['time_since_caption']:'N/A'!!}</span></td>
                                <td class="text-center align-middle" style="white-space: nowrap" data-order="{{$el['time_since_delta']}}">{!! $el['time_since_formatted'] !!}</td>
                                <td class="text-center align-middle" style="white-space: nowrap" data-order="{{$el['pending_in_this_status_delta']}}">{!! $el['pending_in_this_status'] !!}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach
