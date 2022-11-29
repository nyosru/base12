<div class="card" data-place-id="{{$section->place_id}}" data-id="{{$section->id}}">
    <div class="card-header" id="section-{{$section->id}}">
        <i class="fas fa-arrows-alt move-section-btn" title="Move Section" style="color: #aaa;position:absolute;left: 7px;top:21px;font-size:17px;cursor: grab"></i>
        <h2 class="mb-0 ml-2">
            <button class="btn btn-link btn-block text-left @if(!$loop->first)collapsed @endif" type="button" data-toggle="collapse" data-target="#collapse-{{$section->id}}" aria-expanded="{{$loop->first?"true":"false"}}" aria-controls="collapse-{{$section->id}}">
                {{$section->name}}
            </button>
        </h2>
        <div style="position: absolute;right: 5px;top:13px;">
            <div class="dropdown">
                <a class="btn btn-default dropdown-toggle" style="color: #777" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-align-justify"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <a href="#" class="dropdown-item add-new-item-btn" title="Add New Item" data-id="{{$section->id}}"><i class="fas fa-plus"></i> Add New Item</a>
                    <a href="#" class="dropdown-item edit-section-btn" title="Edit Section Name" data-id="{{$section->id}}"><i class="fas fa-pencil-alt"></i> Rename Section</a>
                    <a href="#" class="dropdown-item del-section-btn" title="Remove Section" data-id="{{$section->id}}"><i class="fas fa-times"></i> Delete Section</a>
                </div>
            </div>
        </div>
    </div>
    <div id="collapse-{{$section->id}}" class="collapse {{$loop->first?"show":""}}" aria-labelledby="section-{{$section->id}}" data-parent="#root-block">
        <div class="card-body" data-section-id="{{$section->id}}" style="max-height: 600px;overflow-y: auto;overflow-x: hidden">
            @include('fc-maintainer.section-table')
        </div>
    </div>
</div>
