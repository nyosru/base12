<div class="mb-3 text-center">
    <select class="details-dates form-control m-auto" style="width:auto">
        @foreach($data as $date=>$data_arr)
            <option value="{{$date}}">{{$date}}</option>
        @endforeach
    </select>
</div>
{{--
<table class="table table-bordered  details-table">
    <tbody>
        @foreach($data as $date=>$data_arr)
            <tr class="row-{{$date}}">
                <td class="text-center font-weight-bold" colspan="5">{{$date}} ({{count($data_arr)}})</td>
            </tr>
            @include($table_header_template)
            @foreach(\App\classes\trends\DetailsDataArrSorter::run($data_arr) as $data_el)
                <tr class="row-{{$date}}">
                    <td class="text-center" style="width: 10px">{{$loop->index+1}}</td>
                    <td class="text-left text-nowrap">{{$data_el->date->format('Y-m-d')}}</td>
                    <td class="text-left"><a href="https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id={{$data_el->dashboard_id}}" target="_blank">{!! $data_el->dashboard_tm !!}</a></td>
                    <td class="text-left">{{$data_el->value}}</td>
                    <td class="text-center">
                        <select class="form-control iit-select" data-id="{{$data_el->dashboard_id}}">
                            @foreach($dashboard_in_timings_type_objs as $obj)
                                <option value="{{$obj->id}}" {{$obj->id==(\App\DashboardV2::find($data_el->dashboard_id))->dashboard_in_timings_type_id?'selected':''}}>{{$obj->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
--}}
@foreach($data as $date=>$data_arr)
    <table class="table table-bordered row-{{$date}} details-table">
        <thead>
            <tr>
                <td class="text-center font-weight-bold" colspan="5">{{$date}} ({{count($data_arr)}})</td>
            </tr>
            @include($table_header_template)
        </thead>
        <tbody>
            @foreach(\App\classes\trends\DetailsDataArrSorter::run($data_arr) as $data_el)
                <tr class="row-{{$date}}">
                    <td class="text-center" style="width: 10px">{{$loop->index+1}}</td>
                    <td class="text-left text-nowrap">{{$data_el->date->format('Y-m-d')}}</td>
                    <td class="text-left"><a href="https://trademarkfactory.com/mlcclients/dashboard-trademarks-details.php?id={{$data_el->dashboard_id}}" target="_blank">{!! $data_el->dashboard_tm !!}</a></td>
                    <td class="text-left">{{$data_el->value}}</td>
                    <td class="text-center">
                        <select class="form-control iit-select" data-id="{{$data_el->dashboard_id}}">
                            @foreach($dashboard_in_timings_type_objs as $obj)
                                <option value="{{$obj->id}}" {{$obj->id==(\App\DashboardV2::find($data_el->dashboard_id))->dashboard_in_timings_type_id?'selected':''}}>{{$obj->name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach