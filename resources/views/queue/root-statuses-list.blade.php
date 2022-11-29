@foreach($queue_root_status_objs as $el)
<div class="card">
    <div class="card-header d-flex align-items-center" id="root-status-{{$el->id}}">
        <h2 class="mb-0 flex-grow-1">
            <button class="btn btn-link btn-block text-left root-status" data-id="{{$el->id}}" type="button" data-toggle="collapse" data-target="#root-status-collapse-{{$el->id}}" aria-expanded="false" aria-controls="root-status-collapse-{{$el->id}}">
                {{$el->name}} [<span class="root-total" data-id="{{$el->id}}"><img src="https://trademarkfactory.imgix.net/img/loading.gif" style="height:16px;;width: 16px;"/></span>]
            </button>
        </h2>
        <div class="flex-shrink-1">
            @if($el->name=='Done') @include('queue.days-select') @endif
        </div>
        @if($el->name!='Done')
        <div class="flex-shrink-1 root-numbers-block" data-id="{{$el->id}}">
            <img src="https://trademarkfactory.imgix.net/img/loading.gif" style="height:16px;;width: 16px;"/>
        </div>
        @endif
    </div>

    <div id="root-status-collapse-{{$el->id}}" class="collapse" aria-labelledby="root-status-{{$el->id}}" data-parent="#root-statuses">
        <div class="card-body">
            <div class="list-group">
                @include('queue.sub-statuses-list')
            </div>
        </div>
    </div>
</div>
@endforeach