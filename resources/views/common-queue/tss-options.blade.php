@foreach($dashboard_tss_template_objs as $dashboard_tss_template_obj)
    <option value="{{$dashboard_tss_template_obj->id}}">{{$dashboard_tss_template_obj->template_name}}</option>
@endforeach