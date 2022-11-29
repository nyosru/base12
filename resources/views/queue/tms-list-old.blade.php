<table class="table table-bordered item-table" style="border-collapse: collapse !important;width: 100%;table-layout: fixed">
    <thead>
    <tr>
        <th class="text-left tm-cell">Trademark</th>
        <th class="text-center icon-cell"><img src="http://mincovlaw.com/images/icons/cipo_uspto.jpg" style="width: 20px;height: 12px;"></th>
        {{--<th class="text-left">Client</th>--}}
        <th class="text-center icon-cell">🏁</th>
        <th class="text-center owner-cell"><i class="fas fa-user"></i></th>
        <th class="text-center time-cell"><i class="fas fa-hourglass-end"></i></th>
        <th class="text-center time-cell"><i class="far fa-clock"></i></th>
        <th class="text-center time-cell"><i class="fas fa-history"></i></th>
        <th class="text-center time-cell"><i class="fas fa-user-clock"></i></th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $el)
        @php
            $owner=null;
            $time_since_owner='';
            if($el['dashboard']->dashboardOwnerRows()->whereNull('released_at')->count()){
                $dashboard_owner=$el['dashboard']->dashboardOwnerRows()->whereNull('released_at')->orderBy('id','desc')->first();
                $owner=$dashboard_owner->tmfsales;
                $delta = time() - \DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->created_at)->getTimestamp();
                $time_since_owner = \App\classes\TimeFormatter::dhm($delta);
            }

            $hard_deadline='';
            $hard_deadline_obj=\App\DashboardDeadline::where('dashboard_id',$el['dashboard']->id)
                        ->where('deadline_type_id',1)
                        ->whereNull('deadline_done_at')
                        ->orderBy('id')
                        ->first();
            if($hard_deadline_obj)
                $hard_deadline=\DateTime::createFromFormat('Y-m-d H:i:s',$hard_deadline_obj->deadline_date_at)->format('Y-m-d');
        @endphp
        <tr class="item-row sub-status-tm"
            data-dashboard-id="{{$el['dashboard']->id}}"
            data-tmfsales-id="{{($owner?$owner->ID:0)}}"
            data-tmoffer-login="{{($el['tmoffer']?$el['tmoffer']->Login:'')}}"
            data-tmoffer-id="{{($el['tmoffer']?$el['tmoffer']->ID:'')}}"
            @if(in_array(\Illuminate\Support\Facades\Auth::user()->ID,[1]))
            data-addy-note="{{($el['tmoffer']?\App\classes\ThankYouCardSentTextGetter::run($el['tmoffer']->ID):'[]')}}"
            @endif
            data-trigger="{{$el['time_since_caption']}}"
        >
            <td class="text-center tm-cell
            @if($tmf_filing_queue_status->deadline_warning_hours>0 && $tmf_filing_queue_status->deadline_overdue_hours>0)
            {{(($el['pending_in_this_status_delta']>$tmf_filing_queue_status->deadline_warning_hours*3600) && ($el['pending_in_this_status_delta']<$tmf_filing_queue_status->deadline_overdue_hours*3600))?'bg-warning':''}}
            {{($el['pending_in_this_status_delta']>$tmf_filing_queue_status->deadline_overdue_hours*3600)?'bg-danger':''}}
            @endif" style="height: 100px;padding: 0.32rem">
                <div style="background: white;border:1px solid #565656;border-radius: 5px;height: 100%;">
                    <table style="height: 100%;width: 100%;border: none">
                        <tr>
                            <td style="text-align: center;vertical-align: middle;border: none">
                                <strong class="truncate-overflow" title="{{$el['mark']}}">{!! $el['mark'] !!}</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td class="text-center align-middle icon-cell" title="{{$el['country']}}">{!! $el['flag'] !!} <span style="opacity: 0;position: absolute;left: 0;">{{$el['country']}}</span></td>
            <td class="text-center align-middle icon-cell" style="white-space: nowrap" @if(strlen($el['boom_when_by'])) title="{{$el['boom_when_by']}}" @endif>{!! $el['time_since_caption_icon'] !!}<span style="position: absolute;opacity: 0">{!!strlen($el['time_since_caption'])?$el['time_since_caption']:'N/A'!!}</span></td>
            <td class="text-center align-middle owner-cell" style="white-space: nowrap">
                {{$owner?$owner->LongID:''}}
            </td>
            <td class="text-center align-middle time-cell" style="white-space: nowrap">{{$hard_deadline}}</td>
            <td class="text-center align-middle time-cell" style="white-space: nowrap" data-order="{{$el['time_since_delta']}}">{!! $el['time_since_formatted'] !!}</td>
            <td class="text-center align-middle time-cell" style="white-space: nowrap" data-order="{{$el['pending_in_this_status_delta']}}">{!! $el['pending_in_this_status'] !!}</td>
            <td class="text-center align-middle time-cell" style="white-space: nowrap">
                {{$time_since_owner}}
            </td>
        </tr>
    @endforeach    
    </tbody>
</table>    