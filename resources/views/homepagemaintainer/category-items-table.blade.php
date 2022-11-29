@if($hp_category->homepageCategoryItems->count())
    <table class="table table-bordered item-table" data-category-id="{{$hp_category->id}}">
        @foreach($hp_category->homepageCategoryItems->sortBy('place_id') as $item)
            <tr class="item-row" data-category-id="{{$hp_category->id}}" data-id="{{$item->id}}"
                data-name="{{$item->name}}"
                data-url="{{$item->url}}">
                <td class="text-left">
                    <span class="mr-3"><i class="fas fa-arrows-alt-v move-item" style="cursor: grab;color:#aaa"></i></span><a href="{{$item->url}}" target="_blank">{{$item->name}}</a> <a href="#" class="text-danger delete-category-item float-right" data-category-id="{{$hp_category->id}}" data-id="{{$item->id}}"><i class="fas fa-times"></i></a> <a href="#" class="edit-category-item float-right mr-2"><i class="fas fa-pencil-alt"></i></a>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <div class="text-center">EMPTY</div>
@endif
