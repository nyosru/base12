@foreach($prequalify_request_obj->emailHistoryRows as $obj)
    <div><a href="#" class="show-email-details" data-id="{{$obj->id}}">{!! $obj->prequalify_request_email_type_id==1?'<i class="fas fa-thumbs-down text-danger"></i>':'<i class="fas fa-thumbs-up" style="color:green"></i>'!!} {{\DateTime::createFromFormat('Y-m-d H:i:s',$obj->created_at)->format('M j, Y \@ g:ia')}}</a></div>
@endforeach
