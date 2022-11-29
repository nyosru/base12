<p><strong>Subj</strong>: {{$prequalify_request_email_history->subj}}</p>
<hr/>
<p><strong>From</strong>: {{$prequalify_request_email_history->fromTmfsales->FirstName}} {{$prequalify_request_email_history->fromTmfsales->LastName}}</p>
<hr/>
<p><strong>Email</strong>:<br/><div style="max-height: 450px;overflow-x: hidden;overflow-y: auto">{!! $prequalify_request_email_history->message !!}</div></p>