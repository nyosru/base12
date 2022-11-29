@if(count($objs))
    <table class="table table-bordered" id="main-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Weekday</th>
                <th>Meeting Time</th>
                <th>Members</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($objs as $obj)
                <tr class="t-row" data-region-id="{{$obj->region_id}}" data-weekday="{{$obj->weekday}}" data-time="{{$obj->bni_meeting_time}}" data-members="{{$obj->members}}">
                    <td><a href="{{$obj->link}}" target="_blank">{{$obj->bni->name}}</a></td>
                    <td>{{$obj->address}}</td>
                    <td>{{$obj->weekday}}</td>
                    <td>{{$obj->bni_meeting_time}}</td>
                    <td>{{$obj->members}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif