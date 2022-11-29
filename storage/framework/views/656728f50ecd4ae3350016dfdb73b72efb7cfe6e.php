<style>
    #result-block{display: none;margin: auto;width: 100%}
    #raw-revenues-table{width: 100% !important;}

    #raw-revenues-table_filter{display: none;}

    #pay-type-filter,
    #client-type-filter,
    #client-source-filter,
    #boom-source-filter{width: auto}

    .form-inline{display: block!important;}
/*

    .num{background: #f8dfbe}
    .amount{background: #b4f5b6}
    .num-percent,
    .amount-percent{background: #b3ddf1}
*/

    #cs-content{overflow-y:auto;}

    .num-percent,.amount-percent{white-space: nowrap}
    <?php if($view_suffix!='-public'): ?>
    .num-percent{display: none;}
    <?php endif; ?>

    .amount{width: 102px;}

    .client-source-cell{width: <?php echo e($cs_left_column_width); ?>px;white-space: nowrap;}
    .cs-left-column-cell{white-space: nowrap}

    #cs-left-column{width: <?php echo e($cs_left_column_width); ?>px;}
    
    #cs-right-column{width: <?php echo e($cs_right_column_width); ?>px;}

    .bold-border-right{border-right: 2px solid black !important;}
    .bold-border-left{border-left: 2px solid black !important;}

    .total{background: #eef;font-weight: bold}
    .zero{color:#eee;}

</style><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/tmf-revenue-breakdown/css.blade.php ENDPATH**/ ?>