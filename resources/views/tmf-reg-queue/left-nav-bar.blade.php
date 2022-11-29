<li class="nav-item">
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