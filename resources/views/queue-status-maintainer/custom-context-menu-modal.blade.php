<div class="modal" id="custom-context-menu-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Additional Item In Context Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <span class="font-weight-bold">Standart Menu Items:</span>
                        @foreach($standart_menu_items as $standart_menu_item)
                            <label class="ml-2">
                                <input type="checkbox" class="standart-menu-item" value="{{$standart_menu_item->id}}"/>
                                {!! $standart_menu_item->icon !!} {{$standart_menu_item->name}}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="font-weight-bold mb-3">Custom Menu Items:
                            <button class="btn btn-sm btn-success ml-1" id="new-custom-menu-item">
                                <i class="fas fa-plus-circle"></i> NEW
                            </button>
                        </div>
                        <div class="custom-menu-items-block"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="save-menu-items-btn"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>