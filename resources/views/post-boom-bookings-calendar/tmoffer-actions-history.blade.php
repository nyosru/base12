@if($tmoffer_actions_history_objs->count())
    <table class="table">
        <thead>
            <tr>
                <th class="text-left">Date and time, PST</th>
                <th class="text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tmoffer_actions_history_objs as $el)
                <tr>
                    <td class="text-left">{{(\DateTime::createFromFormat('Y-m-d H:i:s',$el->created_at))->format('Y-m-d \@ g:ia')}}</td>
                    <td class="text-left">{!! $el->action_descr !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">EMPTY</div>
@endif