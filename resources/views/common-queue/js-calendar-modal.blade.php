<div class="modal fade" id="js-calendar-modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-12 text-left">
                                <div id="jscalendar-question"></div>
                                <input type="text" id="jscalendar" class="form-control" style="width: 200px;display: inline-block">
                                <div style="border:none;display: inline-block">
                                    <button class="btn btn-xs btn-info js_calendar_plus_delta" data-delta="6">+6m</button>
                                    <button class="btn btn-xs btn-info js_calendar_plus_delta" data-delta="120">+10y</button>
                                    <button class="btn btn-xs btn-info js_calendar_plus_delta" data-delta="180">+15y</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-right">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="js-calendar-save-btn">OK</button>
                    </div>
                    <div class="overlay" style="display: none;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->