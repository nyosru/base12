<script>
    function setButtonPlusMinus(selector,plusminus){
        if(plusminus=='-'){
            $(selector).data('plus-minus','+');
            $(selector).html('<i class="fa fa-plus" aria-hidden="true"></i>');
        }else{
            $(selector).data('plus-minus','-');
            $(selector).html('<i class="fa fa-minus" aria-hidden="true"></i>');
        }
    }

    function getPrefixes() {
        let prefixes=[];
        $('.flag-settings-table').each(function () {
            prefixes.push($(this).data('prefix'));
        });
        return prefixes;
    }

    function getFlagSettingData(prefix) {
        let result={};
        result.relative_date_type=$('select[name="'+prefix+'-relative-date-type"]').val();
        result.plus_minus=$('.select-plus-minus[data-prefix="'+prefix+'"]').data('plus-minus');
        result.year=$('.deadline-plus-minus-year[data-prefix="'+prefix+'"]').val();
        result.month=$('.deadline-plus-minus-month[data-prefix="'+prefix+'"]').val();
        result.day=$('.deadline-plus-minus-day[data-prefix="'+prefix+'"]').val();
        result.hour=$('.deadline-plus-minus-hour[data-prefix="'+prefix+'"]').val();
        result.plus_minus_settings=$('select[name="'+prefix+'-plus-minus-settings"]').val();
        return result;
    }

    function getAllFlagSettingsData(){
        let prefixes=getPrefixes();
        let data={};
        $.each(prefixes,function (i,val) {
            data[val]=getFlagSettingData(val);
        });
        return data;
    }
    
    function paintFlagSettings(data){
        $.each(data,function (key,val) {
            $('select[name="'+key+'-relative-date-type"]').val(val.relative_date_type);
            $('.select-plus-minus[data-prefix="'+key+'"]').data('plus-minus',val.plus_minus);
            if(val.plus_minus=='-')
                $('.select-plus-minus[data-prefix="'+key+'"]').html('<i class="fa fa-minus" aria-hidden="true"></i>');
            else
                $('.select-plus-minus[data-prefix="'+key+'"]').html('<i class="fa fa-plus" aria-hidden="true"></i>');
            $('.deadline-plus-minus-year[data-prefix="'+key+'"]').val(val.year);
            $('.deadline-plus-minus-month[data-prefix="'+key+'"]').val(val.month);
            $('.deadline-plus-minus-day[data-prefix="'+key+'"]').val(val.day);
            $('.deadline-plus-minus-hour[data-prefix="'+key+'"]').val(val.hour);
            $('select[name="'+key+'-plus-minus-settings"]').val(val.plus_minus_settings);
        });
    }

    $('body').on('click','.select-plus-minus',function () {
        let prefix=$(this).data('prefix');
        setButtonPlusMinus('.select-plus-minus[data-prefix="'+prefix+'"]',$(this).data('plus-minus'));
    });
</script><?php /**PATH /var/www/html/in.trademarkfactory.com/resources/views/common-queue/flag-settings-js.blade.php ENDPATH**/ ?>