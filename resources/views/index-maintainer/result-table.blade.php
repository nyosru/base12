@if(count($data))
    <table class="table table-bordered" id="main-table">
        <tbody>
            @foreach ($data as $section_id=>$el)
                <tr>
                    <td colspan="2" class="bg-light"><strong>Section:</strong> {{$el['name']}}</td>
                </tr>
                @foreach($el['data'] as $item)
                    <tr>
                        <td class="pl-2"><a href="{{$item->url}}" target="_blank">{{$item->name}}</a></td>
                        <td style="width: 90px;text-align: center">
                            <button class="btn btn-sm btn-info edit-btn" data-id="{{$item->id}}" data-section-id="{{$section_id}}"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-sm btn-danger del-btn" data-id="{{$item->id}}"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@endif