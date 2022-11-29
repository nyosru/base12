<table class="table table-bordered details-table">
    @include($table_header_template)
    <tbody>
        @foreach($dashboard_details_data as $dashboard_el)
            <tr>
                <td class="text-left text-nowrap">{{$dashboard_el->date=='N/A'?$dashboard_el->date:$dashboard_el->date->format('Y-m-d')}}</td>
                <td class="text-left"><a href="https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id={{$dashboard_el->dashboard_id}}" target="_blank">{!! $dashboard_el->dashboard_tm !!}</a></td>
                <td class="text-left">{{$dashboard_el->value}}</td>
                <td class="text-center">
                    <select class="form-control iit-select" data-id="{{$dashboard_el->dashboard_id}}">
                        @foreach($dashboard_in_timings_type_objs as $obj)
                            <option value="{{$obj->id}}" {{$obj->id==(\App\DashboardV2::find($dashboard_el->dashboard_id))->dashboard_in_timings_type_id?'selected':''}}>{{$obj->name}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>