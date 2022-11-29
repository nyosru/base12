<table class="table table-bordered" style="margin-bottom: 20px;">
    <thead>
    <tr>
        <th>Question</th>
        <th>Answer</th>
    </tr>
    </thead>
    <tbody>
    @if(strlen($prequalify_request_obj->industry))
        <tr>
            <td class="text-left">In a few words, describe what industry your business pertains to:</td>
            <td class="text-left prospect-answer">{!! nl2br($prequalify_request_obj->industry) !!}</td>
        </tr>
    @endif
    @if($prequalify_request_obj->url)
        <tr>
            <td class="text-left">If you have a website or a social media page where you currently market products or
                services under your brand, please share the link in the field below:
            </td>
            <td class="text-center prospect-answer"><a
                        href="{{strpos($prequalify_request_obj->url,'http')===false?'http://'.$prequalify_request_obj->url:$prequalify_request_obj->url}}"
                        target="_blank">{{$prequalify_request_obj->url}}</a></td>
        </tr>
    @endif
    @foreach($data as $question=>$answers)
        @if(count($answers) && strlen($answers[0]))
            <tr>
                <td class="text-left">{!! $question !!}</td>
                <td class="text-left prospect-answer">{!! implode('<br/><br/>',$answers) !!}</td>
            </tr>
        @endif
    @endforeach
        <tr>
            <td class="text-left">Timezone</td>
            <td class="text-left prospect-answer">{{$timezone}}</td>
        </tr>
    </tbody>
</table>
