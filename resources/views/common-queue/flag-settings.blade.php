<table class="table flag-settings-table" data-prefix="{{$prefix}}" style="border: 0">
    <tr>
        <td style="border: 0;vertical-align: middle">
            <select name="{{$prefix}}-relative-date-type" class="form-control" style="width: auto">
            @foreach($relative_start_date_type_objs as $relative_start_date_type_obj)
                {{--<label><input type="radio" name="{{$prefix}}-relative-date-type" value="2" {{$loop->index==0?'checked':''}}> {{$relative_start_date_type_obj->type_name}}</label><br/>--}}
                    <option value="{{$relative_start_date_type_obj->id}}">{{$relative_start_date_type_obj->type_name}}</option>
            @endforeach
            </select>
        </td>
        <td style="vertical-align: middle;border: 0">
{{--            <div class="d-table">
                <div class="d-table-cell w-25 text-center">
                    <div>
                        <a href="#" class="minus-btn"><i class="far fa-minus-square"></i></a>
                        <span class="pm-digit pm-y">0</span>
                        <a href="#" class="plus-btn"><i class="far fa-plus-square"></i></a>
                    </div>
                     years
                </div>
                <div class="d-table-cell w-25 text-center pl-3">
                    <div>
                        <a href="#" class="minus-btn"><i class="far fa-minus-square"></i></a>
                        <span class="pm-digit pm-m">0</span>
                        <a href="#" class="plus-btn"><i class="far fa-plus-square"></i></a>
                    </div>
                    months
                </div>
                <div class="d-table-cell w-25 text-center pl-3">
                    <div>
                        <a href="#" class="minus-btn"><i class="far fa-minus-square"></i></a>
                        <span class="pm-digit pm-d">0</span>
                        <a href="#" class="plus-btn"><i class="far fa-plus-square"></i></a>
                    </div>
                    days
                </div>
                <div class="d-table-cell w-25 text-center pl-3">
                    <div>
                        <a href="#" class="minus-btn"><i class="far fa-minus-square"></i></a>
                        <span class="pm-digit pm-h">0</span>
                        <a href="#" class="plus-btn"><i class="far fa-plus-square"></i></a>
                    </div>
                    hours
                </div>
            </div>--}}
            <div class="d-table">
                <div class="d-table-cell w-20 text-center align-middle">
                    <button class="btn btn-sm btn-primary select-plus-minus" data-prefix="{{$prefix}}" data-plus-minus="+"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </div>
                <div class="d-table-cell w-20 text-center pl-1">
                    <div>
                        <input type="text" min="0" step="1" class="form-control deadline-plus-minus-year" data-prefix="{{$prefix}}"
                               value="0">
                    </div>
                     years
                </div>
                <div class="d-table-cell w-20 text-center pl-1">
                    <div>
                        <input type="text" min="0" step="1" class="form-control deadline-plus-minus-month" data-prefix="{{$prefix}}"
                               value="0">
                    </div>
                    months
                </div>
                <div class="d-table-cell w-20 text-center pl-1">
                    <div>
                        <input type="text" min="0" step="1" class="form-control deadline-plus-minus-day" data-prefix="{{$prefix}}"
                               value="0">
                    </div>
                    days
                </div>
                <div class="d-table-cell w-20 text-center pl-1">
                    <div>
                        <input type="text" min="0" step="1" class="form-control deadline-plus-minus-hour" data-prefix="{{$prefix}}"
                               value="0">
                    </div>
                    hours
                </div>
            </div>
{{--
            <button class="btn btn-sm btn-primary select-plus-minus" data-prefix="{{$prefix}}" data-plus-minus="+"><i class="fa fa-plus" aria-hidden="true"></i></button>
            <input type="number" min="0" step="1" class="form-control deadline-plus-minus-year" data-prefix="{{$prefix}}"
                   style="display: inline-block;width: 50px;" value="0">Y&nbsp;
            <input type="number" min="0" step="1" class="form-control deadline-plus-minus-month" data-prefix="{{$prefix}}"
                   style="display: inline-block;width: 50px;margin-left: 7px;" value="0">M&nbsp;
            <input type="number" min="0" step="1" class="form-control deadline-plus-minus-day" data-prefix="{{$prefix}}"
                   style="display: inline-block;width: 60px;margin-left: 7px;" value="0">D&nbsp;
            <input type="number" min="0" step="1" class="form-control deadline-plus-minus-hour" data-prefix="{{$prefix}}"
                   style="display: inline-block;width: 60px;margin-left: 7px;" value="0">H&nbsp;
--}}
        </td>
        <td style="border: 0;vertical-align: middle">
            <select name="{{$prefix}}-plus-minus-settings" class="form-control" style="width: auto">
            @foreach($plus_minus_settings_objs as $plus_minus_settings_obj)
                {{--<label><input type="radio" name="{{$prefix}}-plus-minus-settings" value="{{$plus_minus_settings_obj->id}}" {{ $plus_minus_settings_obj->id==2?'checked':''}}> {{$plus_minus_settings_obj->name}}</label>{!! !$loop->last?'<br/>':'' !!}--}}
                    <option value="{{$plus_minus_settings_obj->id}}" {{ $plus_minus_settings_obj->id==2?'selected':''}}>{{$plus_minus_settings_obj->name}}</option>
            @endforeach
            </select>
        </td>
    </tr>
</table>
