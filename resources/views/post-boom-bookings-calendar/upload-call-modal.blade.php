<div class="modal" id="upload-call-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Recordings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="row recently-uploaded-block" style="font-size:11px;margin-bottom: 20px;">
                    <div class="col-md-12 text-center" id="uploaded-files">NO UPLOADED FILES YET</div>
                </div>
                <div class="row" id="upload-files-progress" style="margin-bottom: 15px;display: none;">
                    <div class="col-md-12 text-center">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                0%
                            </div>
                        </div>
                    </div>
                </div>
                <div class="multi-files-dragarea">
                    Drag file here or click to upload
                </div>
                <input type="file" name="upfile[]" id="upfiles" multiple="" style="display: none">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="upload-call-btn">Start Upload</button>
            </div>
        </div>
    </div>
</div>