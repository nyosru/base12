<table class="table table-bordered" id="main-table">
    <thead>
        <tr>
            <th class="text-center">No-Boom Reason</th>
            <th class="text-center">Email Template Subj</th>
            <th style="width: 90px;"></th>
        </tr>
    </thead>
    <tbody>
        @if($not_boom_reasons->count())
            @foreach($not_boom_reasons as $el)
                <tr>
                    <td class="text-left">{{$el->reason}}</td>
                    <td class="text-left">{{$el->email_template_name}}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary edit-btn" data-id="{{$el->id}}" data-template="{{$el->email_template}}"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-sm btn-danger del-btn" data-id="{{$el->id}}"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
            @endforeach
        @else
            <tr><td colspan="3" class="text-center">EMPTY</td></tr>
        @endif
    </tbody>
</table>