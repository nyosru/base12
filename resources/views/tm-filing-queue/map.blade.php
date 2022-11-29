{{--

    <div class="text-center d-inline-block font-weight-bold mr-1" style="width: {{$column_width}}px;float: left;background: transparent">
        <div class="mb-1">{{$th_caption}}</div>
        <div style="height: 700px;overflow-x: hidden;overflow-y: auto;background: {{$bg_arr[$loop->index]}}">
            @foreach($el as $data)
                <a href="#" class="list-group-item list-group-item-action text-left" style="background: transparent">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1 text-center w-100">{!! $data['mark'] !!}</h5>
                    </div>
                    <p class="mb-1">{!! $data['flag'] !!} {{$data['country']}}</p>
                    <p class="mb-1">{{$data['client']}}</p>
                    <small>Time since {!! $data['time_since_caption'] !!}: {!! $data['time_since_formatted'] !!}</small><br/>
                    <small>Pending in this status: {!! $data['pending_in_this_status'] !!}</small>
                </a>
            @endforeach
        </div>
    </div>

--}}

    <div class="card">
        <div class="card-header" id="section-{{$loop->index}}">
            <h2 class="mb-0 ml-2">
                <button class="btn btn-link btn-block text-left @if(!$loop->first)collapsed @endif" type="button" data-toggle="collapse" data-target="#collapse-{{$loop->index}}" aria-expanded="{{$loop->first?"true":"false"}}" aria-controls="collapse-{{$loop->index}}" style="font-size: 14pt">
                    {{$th_caption}} ({{count($el['values'])}})
                </button>
            </h2>
            @if(count($el['acceptable-delays']))
            <div class="badges" style="position: absolute;right: 5px;top:13px;">
                <h2 class="d-inline-block"><span class="badge badge-success"></span></h2>
                <h2 class="d-inline-block"><span class="badge badge-warning"></span></h2>
                <h2 class="d-inline-block"><span class="badge badge-danger"></span></h2>
            </div>
            @endif
        </div>
        <div id="collapse-{{$loop->index}}" class="collapse {{$loop->first?"":""}}" aria-labelledby="section-{{$loop->index}}" data-parent="#root-block">
            <div class="card-body" data-section-id="{{$loop->index}}" style="max-height: 600px;overflow-y: auto;overflow-x: hidden">
                {{--@include('fc-maintainer.section-table')--}}
                @if(count($el['values']))
                    <table class="table table-bordered item-table" data-section-id="{{$loop->index}}" style="border-collapse: collapse !important;width: 100%">
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
                        @foreach($el['values'] as $data)
                            <tr  data-section-id="{{$loop->parent->index}}"
                                data-dashboard-id="{{$data['dashboard']->id}}"
                                data-tmoffer-login="{{($data['tmoffer']?$data['tmoffer']->Login:'')}}"
                                data-trigger="{{$data['time_since_caption']}}"
                                @if(count($el['acceptable-delays']))
                                data-warning="{{(($data['pending_in_this_status_delta']>$el['acceptable-delays'][0]*3600) && ($data['pending_in_this_status_delta']<$el['acceptable-delays'][1]*3600))?1:0}}"
                                data-problem="{{($data['pending_in_this_status_delta']>$el['acceptable-delays'][1]*3600)?1:0}}"
                                data-normal="{{($data['pending_in_this_status_delta']<$el['acceptable-delays'][0]*3600)?1:0}}"
                                data-ad-from="{{$el['acceptable-delays'][0]}}"
                                data-ad-to="{{$el['acceptable-delays'][1]}}"
                                @endif
                                class="item-row"
                            >
                                <td class="text-center
                                    @if(count($el['acceptable-delays']))
                                {{(($data['pending_in_this_status_delta']>$el['acceptable-delays'][0]*3600) && ($data['pending_in_this_status_delta']<$el['acceptable-delays'][1]*3600))?'bg-warning':''}}
                                {{($data['pending_in_this_status_delta']>$el['acceptable-delays'][1]*3600)?'bg-danger':''}}
                                @endif
                                " style="height: 100px;padding: 0.32rem">
                                    <div style="background: white;border:1px solid #565656;border-radius: 5px;height: 100%;">
                                        <table style="height: 100%;width: 100%;border: none">
                                            <tr>
                                                <td style="text-align: center;vertical-align: middle;border: none">
                                                    <strong>{!! $data['mark'] !!}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td class="text-center align-middle" title="{{$data['country']}}">{!! $data['flag'] !!} <span style="opacity: 0;position: absolute;left: 0;">{{$data['country']}}</span></td>
                                <td class="text-center align-middle">{{$data['client']}}</td>
                                <td class="text-center align-middle" style="white-space: nowrap" @if(strlen($data['boom_when_by'])) title="{{$data['boom_when_by']}}" @endif>{!! $data['time_since_caption_icon'] !!}<span style="position: absolute;opacity: 0">{!!strlen($data['time_since_caption'])?$data['time_since_caption']:'N/A'!!}</span></td>
                                <td class="text-center align-middle" style="white-space: nowrap" data-order="{{$data['time_since_delta']}}">{!! $data['time_since_formatted'] !!}</td>
                                <td class="text-center align-middle" style="white-space: nowrap" data-order="{{$data['pending_in_this_status_delta']}}">{!! $data['pending_in_this_status'] !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">EMPTY</div>
                @endif
            </div>
        </div>
    </div>
