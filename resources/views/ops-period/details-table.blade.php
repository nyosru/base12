<table class="table table-bordered" id="details-table">
    <thead>
        <tr>
            <th class="text-center">Trademark</th>
            <th class="text-center">Client</th>
            <th class="text-center">Previous Status</th>
            <th class="text-center" style="width: 74px">Days Until Current Status</th>
            <th class="text-center">Current Status</th>
            <th class="text-center" style="width: 74px">Days Since Current Status</th>
            <th class="text-center">Include In Trends</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $el)
            <tr>
                <td>{!! $el['trademark'] !!}</td>
                <td>{{$el['client']}}</td>
                <td>{{$el['prev-status']}}</td>
                <td>{{$el['prev-status-days']}}</td>
                <td>{{$el['status']}}</td>
                <td>{{$el['days-till-now']}}</td>
                <td class="text-center">
                    <select class="form-control iit-select" data-id="{{$el['id']}}">
                        @foreach($dashboard_in_timings_type_objs as $obj)
                            <option value="{{$obj->id}}" {{$obj->id==$el['in-trends']?'selected':''}}>{{$obj->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>