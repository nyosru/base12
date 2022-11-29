@include('tsw.css')
<div class="tsw" style="padding: 10px;border-top: 1px solid #aaa;border-bottom: 1px solid #aaa;max-width: 500px;min-width: 200px;width: 100%;margin: auto">
    <div style="text-align: center;margin-bottom: 13px;font-weight: 700;">{!! $widget_text  !!}</div>
    <div style="text-align: center;display: table;width: 70%;min-width:200px;margin: auto">
        @foreach ($widget_data as $el)
        <div class="icon-block" style="display:table-cell;height: 33px;width:35px;text-align: center;vertical-align: middle;margin-right: 5px;margin-left: 5px;">
            <a href="{{$el['url']}}" target="_blank"><img src="{{$el['icon']}}" class="icon-img" style="width:30px;height:30px;"></a>
        </div>
        @endforeach
    </div>
</div>