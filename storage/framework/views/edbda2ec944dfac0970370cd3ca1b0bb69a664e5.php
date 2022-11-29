<?php $__env->startSection('title'); ?>
    <?php echo e($title); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <?php echo e($title); ?>

                        <input type="text" class="form-control d-inline-block ml-5" name="yt-filter" id="yt-filter" placeholder="Headline Filter">
                        <label class="mr-3"><input type="radio" name="yt-filter-radio" value="headline" checked/> Headline</label>
                        <label><input type="radio" name="yt-filter-radio" value="url"/> YouTube URL</label>
                        <button class="btn btn-sm btn-success float-right" id="add-new-section-btn">
                            <i class="fas fa-plus"></i> NEW SECTION
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="result-table-block" style="width: 99%;margin: auto">
                            <div class="accordion" id="root-block">
                                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('ns-maintainer.root-block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <div class="modal" id="add-edit-section-modal" tabindex="-1" role="dialog">
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
                        <label class="col-3" for="portal-section">Section Name:</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="section-name"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save-section-btn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="add-edit-item-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="content-tab" data-toggle="tab" href="#content" role="tab" aria-controls="home" aria-selected="true">Content</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">SEO</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-2" id="content" role="tabpanel" aria-labelledby="content-tab">
                            <div class="row mb-3">
                                <label class="col-2" for="item-headline">Headline:</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="item-headline"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-url">Post URL
                                    <a href="#" class="mr-2" id="change-url-link" style="color: green">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                    <a href="#" id="change-underlines-link" style="color: blue">
                                        <i class="fas fa-underline"></i>
                                    </a>:
                                </label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="item-url"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="long-url">Orig. Art. URL:
                                </label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="long-url"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-sniply-url">Orig. Art. Sniply <a href="#"
                                                                                                id="change-sniply-url-link"
                                                                                                style="color: green"><i
                                                class="fas fa-link"></i></a>:</label>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="item-sniply-url"/>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-comment">Comment:</label>
                                <div class="col-10">
                                    <textarea id="item-comment"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-4" for="item-youtube-id">Youtube ID <a href="#" id="copy-yt-id" style="color: green">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>:</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="item-youtube-id"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-2" for="item-twitter">Twitter:</label>
                                <div class="col-10">
                            <textarea id="item-twitter" class="form-control" rows="2"
                                      style="resize: vertical"></textarea>
                                    <span class="el-counter" data-max="275">0 of 275 symbols</span>
                                </div>
                            </div>

                            <div class="row mb-3">

                                <label class="col-2" for="visibility-option-1">Visibility:</label>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="switch-top">
                                                <input type="radio" class="visibility-option-input" name="visibility-option"
                                                       value="visible" id="visibility-option-1" checked>
                                                <label for="visibility-option-1" class="switch-top-label switch-top-label-off">Visible</label>
                                                <input type="radio" class="visibility-option-input" name="visibility-option"
                                                       value="unlisted" id="visibility-option-2">
                                                <label for="visibility-option-2" class="switch-top-label switch-top-label-on">Unlisted</label>
                                                <input type="radio" class="visibility-option-input" name="visibility-option"
                                                       value="hidden" id="visibility-option-3">
                                                <label for="visibility-option-3"
                                                       class="switch-top-label switch-top-label-three">Hidden</label>
                                                <span class="switch-top-selection"></span>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="row">
                                                <label class="col-2" for="item-section">Section:</label>
                                                <div class="col-10">
                                                    <select id="item-section" class="form-control" style="width: auto">
                                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($section->id); ?>"><?php echo e($section->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade p-2" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                            <div class="row mb-4">
                                <label class="col-2" for="seo-title">Title:</label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="seo-title"/>
                                    <span class="el-counter" data-max="60">0 of 60 symbols</span>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-2" for="seo-description">Description:</label>
                                <div class="col-10">
                                    <textarea id="seo-description" class="form-control" rows="4" style="resize: vertical"></textarea>
                                    <span class="el-counter" data-max="160">0 of 160 symbols</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="width: 100%">
                        <button type="button" class="btn btn-danger float-left" id="delete-item-btn">Delete Item
                        </button>
                        <button type="button" class="btn btn-primary float-right" id="save-item-btn">Save</button>
                        <button type="button" class="btn btn-secondary float-right  mr-2" data-dismiss="modal">Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('external-jscss'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <script type="text/javascript" src="https://trademarkfactory.com/selectize/js/standalone/selectize.js"></script>
    <link rel="stylesheet" type="text/css" href="https://trademarkfactory.com/selectize/css/selectize.css"/>
    <link href="http://trademarkfactory.com/js/noty/lib/noty.css" rel="stylesheet">
    <script type="text/javascript" src="http://trademarkfactory.com/js/noty/lib/noty.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/summernote/summernote-bs4.css')); ?>">
    <script src="<?php echo e(asset('plugins/summernote/summernote-bs4.min.js')); ?>"></script>

    <?php echo $__env->make('ns-maintainer.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('ns-maintainer.js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/ns-maintainer/index.blade.php ENDPATH**/ ?>