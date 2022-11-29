<table class="table table-bordered">
    <tbody>
        @foreach($data as $el)
            <tr>
                <td>{!! $el['status']->getIcon() !!} {{$el['status']->getName()}}</td>
                <td>{{$el['status']->getDatetime()}}</td>
                @if($loop->index)
                    <td>{{\App\classes\TimeFormatter::dhm($el['status']->getTimestamp()-$timestamp)}}</td>
                @else
                    <td>&mdash;</td>
                @endif
                @php
                    $timestamp=$el['status']->getTimestamp();
                @endphp
            </tr>
            @if($el['owners-history'])
                @foreach($el['owners-history'] as $dashboard_owner)
                    <tr>
                        <td class="pl-5"><i class="fas fa-user text-success"></i> {{$dashboard_owner->tmfsales->FirstName}} {{$dashboard_owner->tmfsales->LastName}}</td>
                        <td>{{$dashboard_owner->created_at}}</td>
                        <td>{{\App\classes\TimeFormatter::dhm(\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->created_at)->getTimestamp()-$timestamp)}}</td>
                        @php
                            $timestamp=\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->created_at)->getTimestamp();
                        @endphp
                    </tr>
                    @if($dashboard_owner->released_at)
                        <tr>
                            <td class="pl-5"><i class="fas fa-user text-danger"></i> {{$dashboard_owner->tmfsales->FirstName}} {{$dashboard_owner->tmfsales->LastName}}</td>
                            <td>{{$dashboard_owner->released_at}}</td>
                            <td>{{\App\classes\TimeFormatter::dhm(\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->released_at)->getTimestamp()-$timestamp)}}</td>
                            @php
                                $timestamp=\DateTime::createFromFormat('Y-m-d H:i:s',$dashboard_owner->released_at)->getTimestamp();
                            @endphp
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach
    </tbody>
</table>