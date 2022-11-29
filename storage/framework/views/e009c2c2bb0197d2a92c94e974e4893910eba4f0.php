<div class="modal fade" id="email-to-client-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email To Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="my-email" class="col-md-4 control-label">Email:</label>
                            <div class="col-md-8">
                                <input type="email" id="my-email" class="form-control" value=""/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="my-who" class="col-md-4 control-label">Who Sends:</label>
                            <div class="col-md-8">
                                <select id="my-who" class="form-control">
                                    <?php $__currentLoopData = \App\Tmfsales::where('google_calendar_id','!=','')->where('Visible',1)->orderBy('ID','desc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmfsales): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tmfsales->ID); ?>" <?php echo e(($tmfsales->ID==\Illuminate\Support\Facades\Auth::user()->ID?'selected':'')); ?>><?php echo e($tmfsales->FirstName); ?> <?php echo e($tmfsales->LastName); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <label for="my-subject" class="col-md-2 control-label">Subject:</label>
                    <div class="col-md-10">
                        <input type="text" id="my-subject" class="form-control" value=""/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea id="my-message"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="email-to-client-send-btn">Send Email</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal --><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/post-boom-bookings-calendar/email-to-client-modal.blade.php ENDPATH**/ ?>