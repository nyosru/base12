<div class="modal" id="export-to-csv-modal" tabindex="-1" role="dialog">
    <form action="/bookings-calendar/export-to-csv" method="post" target="_blank">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export to CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center" style="margin-bottom:15px;">
                        {!! $months_btns . $q_btns !!}
                        <a href="#" class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</a>
                        {!! $y_select !!}
                    </div>
                    <div class="text-center">
                        <label class="mr-3" style="font-weight: normal;">
                            From Date: <input type="text" id="from_date" name="from_date" class="form-control"
                                              placeholder="YYYY-MM-DD" value=""
                                              style="width: 130px;display: inline-block">
                        </label>
                        <label style="font-weight: normal;">
                            To Date: <input type="text" id="to_date" name="to_date" class="form-control" placeholder="YYYY-MM-DD"
                                            value="<?php echo date('Y-m-d');?>"
                                            style="width: 130px;display: inline-block">
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="start-export-btn">Start Export</button>
                </div>
            </div>
        </div>
    </form>
</div>
