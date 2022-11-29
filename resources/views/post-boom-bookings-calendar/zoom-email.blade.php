<p>Hello {{$client_firstname}},</p>
<p>Here's the information for your call with {{$tmfsales_str}} on {{$booking_datetime_tz->format('F j, Y g:ia')}} ({{$client_tz}}):</p>
<p>Join from PC, Mac, Linux, iOS or Android: <a href="{{$gc_oe_booking->getZoomUrl()}}" target="_blank">{{$gc_oe_booking->getZoomUrl()}}</a></p>
<p>We look forward to helping you protect your brand.</p>
<p>If you cannot attend the call, please <a href="{{$gc_oe_booking->getCancelLink()}}">cancel</a> or <a href="{{$gc_oe_booking->getRebookLink()}}">reschedule</a> your call in advance.</p>
<br/>
{{$current_person->goodbye_text}}<br/>
{{$current_person->FirstName}}<br/>
{!! $signature !!}
