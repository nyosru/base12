<div class="modal" id="add-edit-category-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <label class="col-3" for="portal-section">Category Name:</label>
                    <div class="col-9">
                        <input type="text" class="form-control" id="category-name"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-3" for="portal-section">Bg Color:</label>
                    <div class="col-9">
                        <input type="text" class="form-control" id="bg-color"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-2 text-left">
                        <strong class="mr-1">View Access:</strong> {{--<label><a href="#" data-class="view-access-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-1">ALL</a></label>--}}
                    </div>
                    <div class="col-10 text-left">
                        <label class="mr-1">
                            <input type="checkbox" data-class="view-access-filter-chbx" data-all="1" class="view-access-all-filter-chbx all-btn"> ALL
                        </label>
                        @foreach(\App\EosMember::all() as $eos_member)
                            <label class="mr-1">
                                <input type="checkbox" class="view-access-filter-chbx eos-group" value="{{$eos_member->id}}"> {{$eos_member->name}}
                            </label>
                        @endforeach
                        @foreach(\App\Tmfsales::where('Visible',1)->whereNotIn('ID',[65,70])->orderBy('Level','desc')->get() as $tmfsales)
                            <label class="mr-1">
                                <input type="checkbox" class="view-access-filter-chbx tmfsales" data-groups="{{json_encode($tmfsales->tmfsalesEosMemberRows->pluck('eos_member_id')->toArray())}}" value="{{$tmfsales->ID}}"> {{$tmfsales->FirstName}} {{$tmfsales->LastName}}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-2 text-left">
                        <strong class="mr-1">Admin Access:</strong> {{--<label><a href="#" data-class="admin-access-filter-chbx" data-all="1" class="all-btn badge badge-dark mr-1">ALL</a></label>--}}
                    </div>
                    <div class="col-10 text-left">
                        @foreach(\App\Tmfsales::where('Visible',1)->orderBy('Level','desc')->get() as $tmfsales)
                            <label class="mr-1">
                                <input type="checkbox" class="admin-access-filter-chbx" value="{{$tmfsales->ID}}"> {{$tmfsales->FirstName}} {{$tmfsales->LastName}}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-category-btn">Save</button>
            </div>
        </div>
    </div>
</div>
