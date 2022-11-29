{{--@foreach($data as $el)
    <ul class="list-group list-group-horizontal sub-status-tm"
        data-dashboard-id="{{$el['dashboard']->id}}"
        data-tmoffer-login="{{($el['tmoffer']?$el['tmoffer']->Login:'')}}"
        data-trigger="{{$el['time_since_caption']}}"
    >
        <li class="list-group-item trademark
        @if($tmf_reg_queue_status->deadline_warning_hours>0 && $tmf_reg_queue_status->deadline_overdue_hours>0)
        {{(($el['pending_in_this_status_delta']>$tmf_reg_queue_status->deadline_warning_hours*3600) && ($el['pending_in_this_status_delta']<$tmf_reg_queue_status->deadline_overdue_hours*3600))?'bg-warning':''}}
        {{($el['pending_in_this_status_delta']>$tmf_reg_queue_status->deadline_overdue_hours*3600)?'bg-danger':''}}
        @endif
        ">
            <div style="background: white;border:1px solid #565656;border-radius: 5px;height: 100%;">
                <table style="height: 100%;width: 100%;border: none">
                    <tr>
                        <td style="text-align: center;vertical-align: middle;border: none">
                            <strong>{!! $el['mark'] !!}</strong>
                        </td>
                    </tr>
                </table>
            </div>
        </li>
        <li class="list-group-item country-flag d-flex align-items-center" title="{{$el['country']}}"><div class="d-table-cell align-middle">{!! $el['flag'] !!}</div></li>
        <li class="list-group-item client d-flex align-items-center"><div class="w-100">{{$el['client']}}</div></li>
        <li class="list-group-item since-last-action d-flex align-items-center" @if(strlen($el['boom_when_by'])) title="{{$el['boom_when_by']}}" @endif>
            {!! $el['time_since_caption_icon'] !!}
        </li>
        <li class="list-group-item time-since d-flex align-items-center"><div class="w-100">{!! $el['time_since_formatted'] !!}</div></li>
        <li class="list-group-item pending-in d-flex align-items-center"><div class="w-100">{!! $el['pending_in_this_status'] !!}</div></li>
    </ul>
@endforeach--}}
<table class="table table-bordered item-table" style="border-collapse: collapse !important;width: 100%">
    <thead>
    <tr>
        <th class="text-left">Trademark</th>
        <th class="text-center"><img src="http://mincovlaw.com/images/icons/cipo_uspto.jpg" style="width: 20px;height: 12px;"></th>
        <th class="text-left">Client</th>
        <th class="text-center">🏁</th>
        <th class="text-center">Time since</th>
        <th class="text-center">Pending in<br/>this status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $el)
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
            @if($tmf_reg_queue_status->deadline_warning_hours>0 && $tmf_reg_queue_status->deadline_overdue_hours>0)
            {{(($el['pending_in_this_status_delta']>$tmf_reg_queue_status->deadline_warning_hours*3600) && ($el['pending_in_this_status_delta']<$tmf_reg_queue_status->deadline_overdue_hours*3600))?'bg-warning':''}}
            {{($el['pending_in_this_status_delta']>$tmf_reg_queue_status->deadline_overdue_hours*3600)?'bg-danger':''}}
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
            <td class="text-center align-middle">{{$el['client']}}</td>
            <td class="text-center align-middle" style="white-space: nowrap" @if(strlen($el['boom_when_by'])) title="{{$el['boom_when_by']}}" @endif>{!! $el['time_since_caption_icon'] !!}<span style="position: absolute;opacity: 0">{!!strlen($el['time_since_caption'])?$el['time_since_caption']:'N/A'!!}</span></td>
            <td class="text-center align-middle" style="white-space: nowrap" data-order="{{$el['time_since_delta']}}">{!! $el['time_since_formatted'] !!}</td>
            <td class="text-center align-middle" style="white-space: nowrap" data-order="{{$el['pending_in_this_status_delta']}}">{!! $el['pending_in_this_status'] !!}</td>
            
        </tr>
    @endforeach    
    </tbody>
</table>    