<p>{{$obj->firstname}},</p>
<p>A quick reminder about our call in one hour:</p>
@if($obj->zoom_url)
    <p>At the scheduled time, please go to: <a href="{{$obj->zoom_url}}" target="_blank">{{$obj->zoom_url}}</a></p>
@else
    <p>At the scheduled time, I will call you at the following number: <strong>{{$obj->phone}}</strong>.</p>
@endif
<p>Look forward to talking to you.</p>