<div class="card" data-id="{{$hp_category->id}}">
    <div class="card-header" id="section-{{$hp_category->id}}">
        @if($user_superadmin)
            <i class="fas fa-arrows-alt move-section-btn" title="Move Section" style="color: #aaa;position:absolute;left: 7px;top:21px;font-size:17px;cursor: grab"></i>
            <h2 class="mb-0 ml-2">
        @else
        <h2 class="mb-0">
        @endif
            <button class="btn btn-link btn-block text-left @if(!$loop->first)collapsed @endif" type="button" data-toggle="collapse" data-target="#collapse-{{$hp_category->id}}" aria-expanded="{{$loop->first?"true":"false"}}" aria-controls="collapse-{{$hp_category->id}}">
                {{$hp_category->name}} [<span class="url-count"></span>]
            </button>
        </h2>
        <div style="position: absolute;right: 5px;top:13px;">
            <div class="dropdown">
                <a class="btn btn-default dropdown-toggle" style="color: #777" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-align-justify"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a href="#" class="dropdown-item add-new-item-btn" title="Add New Link" data-id="{{$hp_category->id}}"><i class="fas fa-plus"></i> Add New Link</a>
                    @if($user_superadmin)
                        <a href="#" class="dropdown-item edit-category-btn"
                           data-name="{{ $hp_category->name }}"
                           data-bg-color="{{ $hp_category->bg_color }}"
                           data-view-access-all="{{ $hp_category->view_access_all }}"
                           data-admin-access="{{json_encode($hp_category->homepageCategoryAccessTmfsalesRows()->where('homepage_category_access_type_id',1)->get()->pluck('tmfsales_id')->toArray())}}"
                           data-view-access="{{json_encode($hp_category->homepageCategoryAccessTmfsalesRows()->where('homepage_category_access_type_id',2)->get()->pluck('tmfsales_id')->toArray())}}"
                           data-view-access-group="{{json_encode($hp_category->homepageCategoryGroupAccessRows()->where('homepage_category_access_type_id',2)->get()->pluck('eos_member_id')->toArray())}}"
                           title="Edit Category Name" data-id="{{$hp_category->id}}"><i class="fas fa-pencil-alt"></i> Edit Category</a>
                        <a href="#" class="dropdown-item del-category-btn" title="Remove category" data-id="{{$hp_category->id}}"><i class="fas fa-times"></i> Delete Category</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="collapse-{{$hp_category->id}}" class="collapse {{$loop->first?"show":""}}" aria-labelledby="section-{{$hp_category->id}}" data-parent="#root-block">
        <div class="card-body" data-category-id="{{$hp_category->id}}" style="max-height: 600px;overflow-y: auto;overflow-x: hidden">
            @include('homepagemaintainer.category-items-table')
        </div>
    </div>
</div>
