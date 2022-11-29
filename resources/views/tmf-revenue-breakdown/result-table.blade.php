<table class="table table-bordered" id="main-table">
    <thead>
        <tr>
            <th>Date and Time</th>
            <th>Client</th>
            <th style="width: 40px">Score</th>
            <th>Feedback</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $el)
            <tr>
                <td class="text-left">{{(new \DateTime($el->created_at))->format('Y-m-d H:i')}}</td>
                <td class="text-left" style="white-space: pre-line;max-width: 300px;">{{$el->tmfSubject->first_name.' '.$el->tmfSubject->last_name}}</td>
                <td class="text-center"><img src="{{$el->tmfSatisfactionIconScore->icon}}" style="width: 24px;height: 24px;"/></td>
                <td class="text-left">{!!  nl2br($el->feedback) !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>