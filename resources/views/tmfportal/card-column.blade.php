<div class="card mb-4" style="box-shadow: 3px 3px 5px rgb(0 0 0 / 50%);">
    <div class="card-header" style="background-color: {{$hp_category->bg_color}}">
        @if(\App\HomepageCategoryAccessTmfsales::where('homepage_category_id',$hp_category->id)->where('homepage_category_access_type_id',2)->count()==1)
            <i class="fas fa-user mr-2"></i>
        @else
            <img src="https://trademarkfactory.imgix.net/img/tmficon80.png" class="mr-2" style="max-width: 16px;padding-bottom: 3px;"/>
        @endif
        {{$hp_category->name}}

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
            <a href="#" class="dropdown-item add-new-item-btn" title="Add New Item" data-id="{{$hp_category->id}}"><i class="fas fa-plus"></i> Add New Item</a>
            <a href="#" class="dropdown-item edit-category-btn"
               data-name="{{ $hp_category->name }}"
               title="Edit Category Name" data-id="{{$hp_category->id}}"><i class="fas fa-pencil-alt"></i> Edit Category</a>
            <a href="#" class="dropdown-item del-category-btn" title="Remove category" data-id="{{$hp_category->id}}"><i class="fas fa-times"></i> Delete Category</a>
        </div>

        @if(\App\HomepageCategoryAccessTmfsales::where('homepage_category_id',$hp_category->id)->where('homepage_category_access_type_id',2)->count()==1)
            <div style="position: absolute;right: 5px;top:6px;">
                <div class="dropdown">
                    <a class="btn btn-default dropdown-toggle" style="color: #777" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-align-justify"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a href="#" class="dropdown-item add-new-item-btn" title="Add New Link" data-id="{{$hp_category->id}}"><i class="fas fa-plus"></i> Add New Link</a>
                        <a href="#" class="dropdown-item edit-category-btn"
                           data-name="{{ $hp_category->name }}"
                           title="Edit Category Name" data-id="{{$hp_category->id}}"><i class="fas fa-pencil-alt"></i> Edit Category</a>
                        <a href="#" class="dropdown-item del-category-btn" title="Remove category" data-id="{{$hp_category->id}}"><i class="fas fa-times"></i> Delete Category</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <ul class="list-group list-group-flush">
        @foreach($hp_category->homepageCategoryItems->sortBy('place_id') as $item)
            <li class="list-group-item">
                <a href="{{$item->url}}" target="_blank">{{$item->name}}</a> @if(\App\HomepageCategoryAccessTmfsales::where('homepage_category_id',$hp_category->id)->where('homepage_category_access_type_id',2)->count()==1)<span class="float-right"><a href="#" class="edit-category-item mr-2" data-category-id="{{$hp_category->id}}" data-name="{{$item->name}}" data-url="{{$item->url}}" data-id="{{$item->id}}"><i class="fas fa-pencil-alt"></i></a> <a href="#" class="text-danger delete-category-item" data-category-id="{{$hp_category->id}}" data-id="{{$item->id}}"><i class="fas fa-times"></i></a></span> @endif
            </li>
        @endforeach
    </ul>
</div>
