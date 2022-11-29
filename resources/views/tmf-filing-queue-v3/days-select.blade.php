<select class="days-select mr-2" data-root-id="{{$el->id}}">
    @foreach($days_select_arr as $day)
        <option value="{{$day}}" {{$selected_day==$day?'selected':''}}>{{$day}} days</option>
    @endforeach
</select>