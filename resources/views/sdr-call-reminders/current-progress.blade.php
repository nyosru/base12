<div class="row">
    <div class="col-md-4">
        <div class="text-center mb-1 text-bold">UNHANDLED CALLS</div>
        <div class="list-group connected-div u-calls" id="u-calls" style="min-height: 200px;">
            @foreach($data['unhandled'] as $el)
                <a href="#" class="list-group-item list-group-item-action" data-id="{{$el['tmf-booking']->id}}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{$el['fn']}} {{$el['ln']}}</h5>
                        <small></small>
                        <small class="notes ml-1">
                                <i class="fas fa-sticky-note mr-1" style="color:orange" data-tmoffer-id="{{$el['tmoffer-id']}}" title="Notes"></i>
                                <i class="fas fa-user-clock" data-tmoffer-id="{{$el['tmoffer-id']}}" style="color:blue"></i>
                        </small>
                    </div>
                    <p class="mb-1"><i class="far fa-calendar-alt"></i> {{\DateTime::createFromFormat('Y-m-d H:i:s',$el['tmf-booking']->booked_date)->setTimezone(new DateTimeZone($el['tmf-booking']->timezone))->format('F j, Y \@ g:ia')}} ({{str_replace('_',' ',explode('/',$el['tmf-booking']->timezone)[1])}})</p>
                    <small>Closer: {{\App\Tmfsales::find($el['tmf-booking']->sales_id)->FirstName}} {{\App\Tmfsales::find($el['tmf-booking']->sales_id)->LastName}}. Phone: {{$el['phone']}}</small>
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-center mb-1 text-bold">IN PROGRESS</div>
        <div class="list-group connected-div ip-calls" id="ip-calls" style="min-height: 200px;">
            @foreach($data['in progress'] as $el)
                <a href="#" class="list-group-item list-group-item-action" data-id="{{$el['tmf-booking']->id}}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{$el['fn']}} {{$el['ln']}}</h5>
                        <small>{{$el['tmf-booking']->sdr->LongID}}</small>
                        <small class="notes ml-1">
                            <i class="fas fa-sticky-note mr-1" style="color:orange" data-tmoffer-id="{{$el['tmoffer-id']}}" title="Notes"></i>
                            <i class="fas fa-user-clock" data-tmoffer-id="{{$el['tmoffer-id']}}" style="color:blue"></i>
                        </small>
                    </div>
                    <p class="mb-1"><i class="far fa-calendar-alt"></i> {{\DateTime::createFromFormat('Y-m-d H:i:s',$el['tmf-booking']->booked_date)->setTimezone(new DateTimeZone($el['tmf-booking']->timezone))->format('F j, Y \@ g:ia')}} ({{str_replace('_',' ',explode('/',$el['tmf-booking']->timezone)[1])}})</p>
                    <small>Closer: {{\App\Tmfsales::find($el['tmf-booking']->sales_id)->FirstName}} {{\App\Tmfsales::find($el['tmf-booking']->sales_id)->LastName}}. Phone: {{$el['phone']}}</small>
                </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-4">
        <div class="text-center mb-1 text-bold">FINISHED</div>
        <div class="list-group connected-div finished-calls" id="finished-calls" style="min-height: 200px;">
            @foreach($data['finished'] as $el)
                <a href="#" class="list-group-item list-group-item-action" data-id="{{$el['tmf-booking']->id}}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{$el['fn']}} {{$el['ln']}}</h5>
                        <small>{{$el['tmf-booking']->sdr->LongID}}</small>
                        <small class="notes ml-1">
                            <i class="fas fa-sticky-note mr-1" style="color:orange" data-tmoffer-id="{{$el['tmoffer-id']}}" title="Notes"></i>
                            <i class="fas fa-user-clock" data-tmoffer-id="{{$el['tmoffer-id']}}" style="color:blue"></i>
                        </small>
                    </div>
                    <p class="mb-1"><i class="far fa-calendar-alt"></i> {{\DateTime::createFromFormat('Y-m-d H:i:s',$el['tmf-booking']->booked_date)->setTimezone(new DateTimeZone($el['tmf-booking']->timezone))->format('F j, Y \@ g:ia')}} ({{str_replace('_',' ',explode('/',$el['tmf-booking']->timezone)[1])}})</p>
                    <small>Closer: {{\App\Tmfsales::find($el['tmf-booking']->sales_id)->FirstName}} {{\App\Tmfsales::find($el['tmf-booking']->sales_id)->LastName}}. Phone: {{$el['phone']}}</small>
                </a>
            @endforeach
        </div>
    </div>
</div>
