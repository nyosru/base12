<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <select id="queue-type" class="form-control w-auto">
                @foreach($queue_type_objs as $queue_type_obj)
                    <option value="{{$queue_type_obj->id}}" {{session('queue-type-id')?(session('queue-type-id')==$queue_type_obj->id?'selected':''):''}}>{{$queue_type_obj->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</li>
<li class="nav-item ml-3">
    <a class="nav-link" href="#" id="search-link">Search <i class="fas fa-search"></i></a>
</li>
<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <label class="mb-0"><input type="checkbox" name="group-by-client" value="1"> Group by Client</label>
        </div>
    </div>
</li>
<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <label class="mb-0"><input type="checkbox" id="claimed-by-me-only-chbx" value="1" {{session('claimed-by-me')?'checked':''}}> Claimed by me Only</label>
        </div>
    </div>
</li>
<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <label class="mb-0"><input type="checkbox" id="review-requested-only-chbx" value="1" {{session('review-requested-only')?'checked':''}}> Review Requested Only</label>
        </div>
    </div>
</li>
{{--
@if(in_array(\Illuminate\Support\Facades\Auth::user()->ID,[1,53,73]))
<li class="nav-item d-flex align-items-center">
    <div class="row ml-3">
        <div class="col-md-12">
            <label class="mb-0">Owners Actions: {{\App\DashboardOwner::all()->count()}}</label>
        </div>
    </div>
</li>
@endif--}}
