<script type="text/javascript">

    Number.prototype.formatMoney = function(c, d, t){
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    function getSpinnerHTML() {
        return '<div class="text-center">\n' +
            '<div class="spinner-border" role="status">\n' +
            '<span class="visually-hidden">Loading...</span>\n' +
            '</div>\n' +
            '</div>\n';
    }

    function addEvent(selector,event,func) {
        if(document.getElementById(selector))
            document.getElementById(selector).addEventListener(event,func);
    }

    function getAAlinkByLogin(login) {
        return 'https://trademarkfactory.com/mlcclients/acceptedagreements.php?login='+login+
            '&sbname=&sbphone=&sbtm=&sbemail=&sbnote=&date_from=&date_to=&affiliate_camefrom=&sort_by=new_logins_first&show=ALL&sbmt_btn=SEARCH&page=1';
    }

    function getShoppingCartLinkByLogin(login) {
        return 'https://trademarkfactory.com/shopping-cart/'+login+'&donttrack=1';
    }

    function getCompanyName(fn,company) {
        if(fn.toLowerCase()==company.toLowerCase())
            return '';
        return '('+company+')';
    }

    function paintLatestBoomsWidget(json) {
        var obj=JSON.parse(json);
        var html='';
        var li=[];
        if(obj.count){
            obj.data.forEach(function (val,index) {
                var local_html='<li class="list-group-item">'+
                    val.date+' '+
                    val.company_info.firstname+
                    ' '+
                    val.company_info.lastname+
                    ' '+getCompanyName(val.company_info.firstname+' '+val.company_info.lastname,val.company_info.company)+
                    ' - '+
                    val.selected_currency+' $'+
                    val.amount.formatMoney(2,'.',',')+
                    ' <a href="'+getAAlinkByLogin(val.tmoffer_login)+'" class="float-end" target="_blank">view</a></li>';
                li.push(local_html);
            });
            html='<ul class="list-group list-group-flush">'+li.join('');
            if(obj.count>5) {
                html += '<li class="list-group-item"><a href="#" id="see-all-booms-link">Click to see all ' + obj.count + ' BOOMs &gt;&gt;</a></li>';
            }
            html+='</ul>';
        }else
            html='<ul class="list-group list-group-flush"><li class="list-group-item text-center">EMPTY</li></ul>';

        document.getElementById('latest-booms-content').innerHTML=html;
        addEvent('see-all-booms-link','click',function (e) {
            loadAllBooms();
            e.preventDefault();
            e.stopPropagation();
        });
    }

    function loadAllBooms() {
        document.getElementById('common-modal-title').innerText='BOOMs';
        var common_modal_body=document.getElementById('common-modal-body');
        common_modal_body.innerHTML=getSpinnerHTML();
        var common_modal = new bootstrap.Modal(document.getElementById('common-modal'), {
            keyboard: false
        });
        common_modal.show();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','/closers-dashboard/all-booms');
        xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content);
        xhr.onload=function (){
            if (xhr.status === 200) {
                common_modal_body.innerHTML = xhr.responseText;
                common_modal_body.style.padding=0;
            }else
                if (xhr.status !== 200)
                    console.log('Request failed.  Returned status of ' + xhr.status);
        };
        var form_data=new FormData();
        form_data.append('tmfsales_id',{{$tmfsales->ID}});
        xhr.send(form_data);
    }

    function loadLatestBooms(){
        document.getElementById('latest-booms-content').innerHTML=getSpinnerHTML();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','/closers-dashboard/latest-booms');
        xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content);
        xhr.onload=function (){
            if (xhr.status === 200)
                paintLatestBoomsWidget(xhr.responseText);
            else
                if (xhr.status !== 200)
                    console.log('Request failed.  Returned status of ' + xhr.status);
        };
        var form_data=new FormData();
        form_data.append('tmfsales_id',{{$tmfsales->ID}});
        xhr.send(form_data);
    }

    function paintUpcomingBookingsWidget(json) {
        var obj=JSON.parse(json);
        var html='';
        var li=[];
        if(obj.length){
            obj.forEach(function (val,index) {
                var local_html='<li class="list-group-item">'+
                    val.booking_datetime+' '+
                    val.company_info.firstname+
                    ' '+
                    val.company_info.lastname+
                    ' <a href="'+getShoppingCartLinkByLogin(val.tmoffer_login)+'" class="float-end" target="_blank"><i class="fas fa-shopping-cart"></i></a></li>';
                li.push(local_html);
            });
            html='<ul class="list-group list-group-flush">'+li.join('');
            if(obj.length>=5) {
                html += '<li class="list-group-item"><a href="#" id="see-all-upcoming-bookings-link">Click to see full list &gt;&gt;</a></li>';
            }
            html+='</ul>';
        }else
            html='<ul class="list-group list-group-flush"><li class="list-group-item text-center">EMPTY</li></ul>';


        document.getElementById('upcoming-booking-calls-content').innerHTML=html;
        addEvent('see-all-upcoming-bookings-link','click',function (e) {
            loadAllUpcomingBookings();
            e.preventDefault();
            e.stopPropagation();
        });
    }

    function loadAllUpcomingBookings() {
        document.getElementById('common-modal-title').innerText='Upcoming Booking Calls';
        var common_modal_body=document.getElementById('common-modal-body');
        common_modal_body.innerHTML=getSpinnerHTML();
        var common_modal = new bootstrap.Modal(document.getElementById('common-modal'), {
            keyboard: false
        });
        common_modal.show();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','/closers-dashboard/all-upcoming-bookings');
        xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content);
        xhr.onload=function (){
            if (xhr.status === 200) {
                common_modal_body.innerHTML = xhr.responseText;
                common_modal_body.style.padding=0;
            }else
            if (xhr.status !== 200)
                console.log('Request failed.  Returned status of ' + xhr.status);
        };
        var form_data=new FormData();
        form_data.append('tmfsales_id',{{$tmfsales->ID}});
        xhr.send(form_data);
    }



    function loadUpcomingBookings(){
        document.getElementById('upcoming-booking-calls-content').innerHTML=getSpinnerHTML();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','/closers-dashboard/upcoming-bookings');
        xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content);
        xhr.onload=function (){
            if (xhr.status === 200)
                paintUpcomingBookingsWidget(xhr.responseText);
            else
                if (xhr.status !== 200)
                    console.log('Request failed.  Returned status of ' + xhr.status);
        };
        var form_data=new FormData();
        form_data.append('tmfsales_id',{{$tmfsales->ID}});
        xhr.send(form_data);
    }

    function paintEmptyCallReports(json) {
        var obj=JSON.parse(json);
        var html='';
        var li=[];
        if(obj.length){
            obj.forEach(function (val,index) {
                var local_html='<li class="list-group-item">'+
                    val.date+' '+
                    val.company_info.firstname+
                    ' '+
                    val.company_info.lastname+
                    ' <a href="/bookings-calendar/call-report/'+val.tmoffer_login+'" class="float-end" target="_blank"><i class="fas fa-file"></i></a></li>';
                li.push(local_html);
            });
            html='<ul class="list-group list-group-flush">'+li.join('');
            if(obj.length>=5) {
                html += '<li class="list-group-item"><a href="#" id="see-all-empty-call-reports-link">Click to see full list &gt;&gt;</a></li>';
            }
            html+='</ul>';
        }else
            html='<ul class="list-group list-group-flush"><li class="list-group-item text-center">EMPTY</li></ul>';


        document.getElementById('empty-call-reports-content').innerHTML=html;
/*        addEvent('see-all-upcoming-bookings-link','click',function (e) {
            loadAllUpcomingBookings();
            e.preventDefault();
            e.stopPropagation();
        });*/
    }


    function loadEmptyCallReports(){
        document.getElementById('empty-call-reports-content').innerHTML=getSpinnerHTML();
        var xhr=new XMLHttpRequest();
        xhr.open('POST','/closers-dashboard/empty-call-reports');
        xhr.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content);
        xhr.onload=function (){
            if (xhr.status === 200)
                paintEmptyCallReports(xhr.responseText);
            else
                if (xhr.status !== 200)
                    console.log('Request failed.  Returned status of ' + xhr.status);
        };
        var form_data=new FormData();
        form_data.append('tmfsales_id',{{$tmfsales->ID}});
        xhr.send(form_data);
    }

    document.addEventListener("DOMContentLoaded", function(event) {
        loadLatestBooms();
        loadUpcomingBookings();
        loadEmptyCallReports();
    });

</script>
