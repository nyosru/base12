<?php $__env->startSection('title'); ?>
    Ask Stat
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Ask Stat</div>

                    <div class="card-body">
                        <div style="margin:auto;width:70%;">
                            <div class="text-center" style="margin-bottom:15px">
                                <?php echo $months_btns.$q_btns;?>
                                <button class="btn btn-sm btn-info y-btn" style="margin-right: 7px;color:white;">Y</button>
                                <?php echo $y_select;?>
                            </div>
                            <div class="row" style="margin:auto;margin-bottom: 15px">
                                <label style="font-weight: normal;" class="control-label col-md-5">
                                    From Date: <input type="text" id="from_date" class="form-control" placeholder="YYYY-MM-DD" value="" style="width: 130px;display: inline-block">
                                </label>
                                <label style="font-weight: normal;" class="control-label col-md-5">
                                    To Date: <input type="text" id="to_date" class="form-control" placeholder="YYYY-MM-DD" value="<?php echo date('Y-m-d');?>" style="width: 130px;display: inline-block">
                                </label>
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="show-data">SHOW</button>
                                </div>
                            </div>
                            <div id="result-table" style="text-align: center">
                                <div style="display: inline-block;text-align: left">
                                    <div id="jstree"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('external-jscss'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link href="<?php echo e(asset('jstree/dist/themes/default/style.min.css')); ?>" rel="stylesheet"/>
    <style>
        .jstree-default a {
            white-space:normal !important; height: auto;
        }
        .jstree-anchor {
            height: auto !important;
        }
        .jstree-default li > ins {
            vertical-align:top;
        }
        .jstree-leaf {
            height: auto;
        }
        .jstree-leaf a{
            height: auto !important;
        }
    </style>
    <script src="<?php echo e(asset('jstree/dist/jstree.min.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var jstree_json=<?php echo $jstree_json; ?>;

        function initJSTree(){
            $('#jstree').jstree({
                'core' : {
                    "themes" : {
                        "default" : "large",
                    },
                    'data' : [jstree_json]
                }
            });
        }

        $(document).ready(function () {
            initJSTree();

            var dateFormat = "yy-mm-dd",
                from = $("#from_date")
                    .datepicker({
                        changeMonth: true,
                        numberOfMonths: 1,
                        minDate: "2020-06-10",
                        dateFormat: dateFormat
                    })
                    .on("change", function () {
                        to.datepicker("option", "minDate", getDate(this));
                    }),
                to = $("#to_date").datepicker({
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat,
                    minDate: "2020-06-10",
                    maxDate: "2025-06-10",

                })
                    .on("change", function () {
                        from.datepicker("option", "maxDate", getDate(this));
                    });

            function getDate(element) {
                var date;
                try {
                    date = $.datepicker.parseDate(dateFormat, element.value);
                } catch (error) {
                    date = null;
                }

                return date;
            }

            $('#show-data').click(function () {
                $.post(
                    location.href,
                    {from_date: $.trim($('#from_date').val()), to_date: $.trim($('#to_date').val())},
                    function (msg) {
                        if(msg.length) {
                            jstree_json=JSON.parse(msg);
                            $('#jstree').jstree(true).settings.core.data = jstree_json;
                            $('#jstree').jstree(true).refresh();
                        }else
                            $('#jstree').html('EMPTY');
                    }
                );
            });
        });

        $('.q-btn,.month-btn').click(function () {
            $('#from_date').val($('#s-year').val() + '-' + $(this).data('from'));
            $('#to_date').val($('#s-year').val() + '-' + $(this).data('to'));
        });

        $('.y-btn').click(function () {
            $('#from_date').val($('#s-year').val() + '-01-01');
            $('#to_date').val($('#s-year').val() + '-12-31');
        });

        $('body').on('click','#7rf-stats-link',function (e) {
            var url = $(this).attr('href');
            window.open(url, '_blank');
           e.preventDefault();
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/ask-stat/index.blade.php ENDPATH**/ ?>