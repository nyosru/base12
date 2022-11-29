@if($prequalify_request->lead_status_id)
    {{$prequalify_request->tmfsales->LongID}}: {{$prequalify_request->leadStatus->name}}<a href="#" class="edit-claimed-request"
                                                                                                   data-id="{{$prequalify_request->id}}"
                                                                                                   data-temperature="{{$prequalify_request->temperature?$prequalify_request->temperature:3}}"
                                                                                                   data-needs-tm="{{$prequalify_request->needs_tm?$prequalify_request->needs_tm:1}}"
                                                                                                   data-knows-offer="{{$prequalify_request->knows_offer?$prequalify_request->knows_offer:1}}"
                                                                                                   data-lead-status="{{$prequalify_request->lead_status_id}}"
    ><sup><i class="fas fa-pencil-alt"></i></sup></a><br/>
    <a href="#" class="pq-notes" data-id="{{$prequalify_request->id}}" data-notes="{{$prequalify_request->notes}}" data-notes-alt="{{nl2br($prequalify_request->notes)}}">Notes</a>
@else
    <a href="#" class="unclaimed-link" data-id="{{$prequalify_request->id}}">UNCLAIMED</a>
@endif
