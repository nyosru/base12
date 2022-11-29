<style>

    p.participants{margin: 0; white-space: nowrap;overflow: hidden;text-overflow: ellipsis}

    .fc-popover-body.popover-body{max-height: 450px;overflow-y: auto;overflow-x: hidden}

    .filter-block{background: rgba(0, 0, 0, 0.03);padding: 10px;border: 1px solid #ddd;margin-right: 10px;border-radius: 5px;}

    .booked-with{max-width: 250px;vertical-align: top;}
    .closer-calls-fblock{max-width: 615px;vertical-align: top;}
    .gc-calls-fblock{background: #C0DFF6;}
    .oe-calls-fblock{background: #EEEE92;}
    .sou-calls-fblock{background: #ECC4F7;}

    .f-label{width:120px;}

    .closing-call-type{position: relative;top:3px;}

    .inactive-closer{display: none}

    a[data-class="cc-from-filter-chbx"],
    a[data-class="closeable-filter-chbx"]{position: relative;top:-3px;}

    .booking-type-filter{
        position: relative;
        top:2px;
    }

    .closing-types{
        color:white;
    }

    .call-types-filter-results{color:white;}

    .closing-types .badge{
        position: relative;
        top:-3px;
    }

    .multi-files-dragarea {
        cursor: pointer;
        border: 1px dashed #999;
        border-radius: 5px;
        /*display: inline-block;*/
        padding: 100px;
        /*position: relative;*/
        /*top: -3px;*/
        /*margin-right: 3px;*/
        /*margin-top: 5px;*/
        background: transparent;
    }


    .fc .fc-more-popover .fc-popover-body{
        background: white !important;
    }

    .dropdown-item .fas,
    .dropdown-item .far
    {
        text-align: center;
        width: 20px;
    }

    .booking-time-cell{
        width:11px;
        vertical-align: middle !important;
        text-align: center;
    }

    .booking-source-icon{
        max-width: 14px;
        max-height: 14px;
        position: absolute;
        top:9px;
        right: 6px;
    }

    .participants{
        font-size: 8pt;
    }

    .booking-slot-icon{
        width: 16px;
        height: 15px;
        margin-right: 4px;
        border-radius: 5px;
    }

    .booking-time{
        position: relative;
        top:7px;
        font-size:11px;
        transform: rotate(-90deg);
        /* Legacy vendor prefixes that you probably don't need... */

        /* Safari */
        -webkit-transform: rotate(-90deg);

        /* Firefox */
        -moz-transform: rotate(-90deg);

        /* IE */
        -ms-transform: rotate(-90deg);

        /* Opera */
        -o-transform: rotate(-90deg);

        /* Internet Explorer */
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
    }

    .fc-toolbar-title{
        cursor: pointer;
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu a::after {
        transform: rotate(-90deg);
        position: absolute;
        right: 6px;
        top: .8em;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-left: .1rem;
        margin-right: .1rem;
    }

    a.dropdown-item{
        padding: 7px;
    }

    #context-menu>li>a{
        background: transparent;
        display: block;
        padding: 5px;
        text-decoration: none;
    }
    #context-menu>li>a:hover,
    .dropdown-item:hover{background: orange}

    #context-menu{
        padding: 0;
        box-shadow: 5px 5px 5px;
        border: 2px solid gray;

    }

    .fc-daygrid-event-harness{
        margin-bottom: 2px;
    }

    #payments-methods{
        display: none;
    }

    .ready-option-input,
    .type-option-input,
    .countries-option-input,
    .deadlines-show-settings-input,
    .deleted-option-input {
        display: none;
    }

    .ready-option-input:checked + .switch-top-label,
    .type-option-input:checked + .switch-top-label,
    .deadlines-show-settings-input:checked + .switch-top-label,
    .countries-option-input:checked + .switch-top-label,
    .deleted-option-input:checked + .switch-top-label {
        font-weight: bold;
        color: rgba(0, 0, 0, 0.65);
        text-shadow: 0 1px rgba(255, 255, 255, 0.25);
        -webkit-transition: 0.15s ease-out;
        -moz-transition: 0.15s ease-out;
        -ms-transition: 0.15s ease-out;
        -o-transition: 0.15s ease-out;
        transition: 0.15s ease-out;
        -webkit-transition-property: color, text-shadow;
        -moz-transition-property: color, text-shadow;
        -ms-transition-property: color, text-shadow;
        -o-transition-property: color, text-shadow;
        transition-property: color, text-shadow;
    }
    .ready-option-input:checked + .switch-top-label-on ~ .switch-top-selection,
    .type-option-input:checked + .switch-top-label-on ~ .switch-top-selection,
    .deadlines-show-settings-input:checked + .switch-top-label-on ~ .switch-top-selection,
    .countries-option-input:checked + .switch-top-label-on ~ .switch-top-selection,
    .deleted-option-input:checked + .switch-top-label-on ~ .switch-top-selection {
        left: 60px;
    }

    .ready-option-input:checked + .switch-top-label-three ~ .switch-top-selection,
    .type-option-input:checked + .switch-top-label-three ~ .switch-top-selection,
    .deadlines-show-settings-input:checked + .switch-top-label-three ~ .switch-top-selection,
    .countries-option-input:checked + .switch-top-label-three ~ .switch-top-selection,
    .deleted-option-input:checked + .switch-top-label-three ~ .switch-top-selection {
        left: 120px;
    }

    .ready-option-input:checked + .switch-top-label-off ~ .switch-top-selection,
    .type-option-input:checked + .switch-top-label-off ~ .switch-top-selection,
    .deadlines-show-settings-input:checked + .switch-top-label-off ~ .switch-top-selection,
    .countries-option-input:checked + .switch-top-label-off ~ .switch-top-selection,
    .deleted-option-input:checked + .switch-top-label-off ~ .switch-top-selection {
        left: 2px;
    }

    .switch-top {
        position: relative;
        height: 26px;
        width: 180px;
        /*margin: 12px 20px 0px 20px;*/
        background: rgba(0, 0, 0, 0.25);
        border-radius: 3px;
        -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    }

    .switch-top-label {
        position: relative;
        z-index: 2;
        float: left;
        width: 60px;
        line-height: 26px;
        font-size: 11px;
        color: rgba(0, 0, 0, 0.35);
        text-align: center;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
        cursor: pointer;
    }
    .switch-top-label:active {
        font-weight: bold;
    }

    .switch-top-label-off {
        padding-right: 2px;
    }

    .switch-top-label-on {
        padding-right: 2px;
    }

    .switch-top-label-three {
        padding-right: 2px;
    }


    .switch-top-input,
    .switch-ready-input{
        display: none;
    }

    .switch-ready-input:checked + .switch-top-label,
    .switch-top-input:checked + .switch-top-label {
        font-weight: bold;
        color: rgba(0, 0, 0, 0.65);
        text-shadow: 0 1px rgba(255, 255, 255, 0.25);
        -webkit-transition: 0.15s ease-out;
        -moz-transition: 0.15s ease-out;
        -ms-transition: 0.15s ease-out;
        -o-transition: 0.15s ease-out;
        transition: 0.15s ease-out;
        -webkit-transition-property: color, text-shadow;
        -moz-transition-property: color, text-shadow;
        -ms-transition-property: color, text-shadow;
        -o-transition-property: color, text-shadow;
        transition-property: color, text-shadow;
    }
    .switch-ready-input:checked + .switch-top-label-on ~ .switch-top-selection,
    .switch-top-input:checked + .switch-top-label-on ~ .switch-top-selection {
        left: 60px;
        /* Note: left: 50%; doesn't transition in WebKit */
    }

    .switch-ready-input:checked + .switch-top-label-three ~ .switch-top-selection,
    .switch-top-input:checked + .switch-top-label-three ~ .switch-top-selection {
        left: 120px;
        /* Note: left: 50%; doesn't transition in WebKit */
    }

    .switch-ready-input:checked + .switch-top-label-off ~ .switch-top-selection,
    .switch-top-input:checked + .switch-top-label-off ~ .switch-top-selection {
        left: 2px;
        /* Note: left: 50%; doesn't transition in WebKit */
    }

    .switch-top-selection {
        position: absolute;
        z-index: 1;
        top: 2px;
        left: 2px;
        display: block;
        width: 58px;
        height: 22px;
        border-radius: 3px;
        background-color: #65bd63;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #9dd993), color-stop(100%, #65bd63));
        background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
        background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
        background-image: -ms-linear-gradient(top, #9dd993, #65bd63);
        background-image: -o-linear-gradient(top, #9dd993, #65bd63);
        background-image: linear-gradient(top, #9dd993, #65bd63);
        -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
        -webkit-transition: left 0.15s ease-out;
        -moz-transition: left 0.15s ease-out;
        -ms-transition: left 0.15s ease-out;
        -o-transition: left 0.15s ease-out;
        transition: left 0.15s ease-out;
    }
    .switch-top-blue .switch-top-selection {
        background-color: #3aa2d0;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #4fc9ee), color-stop(100%, #3aa2d0));
        background-image: -webkit-linear-gradient(top, #4fc9ee, #3aa2d0);
        background-image: -moz-linear-gradient(top, #4fc9ee, #3aa2d0);
        background-image: -ms-linear-gradient(top, #4fc9ee, #3aa2d0);
        background-image: -o-linear-gradient(top, #4fc9ee, #3aa2d0);
        background-image: linear-gradient(top, #4fc9ee, #3aa2d0);
    }
    .switch-top-yellow .switch-top-selection {
        background-color: #c4bb61;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #e0dd94), color-stop(100%, #c4bb61));
        background-image: -webkit-linear-gradient(top, #e0dd94, #c4bb61);
        background-image: -moz-linear-gradient(top, #e0dd94, #c4bb61);
        background-image: -ms-linear-gradient(top, #e0dd94, #c4bb61);
        background-image: -o-linear-gradient(top, #e0dd94, #c4bb61);
        background-image: linear-gradient(top, #e0dd94, #c4bb61);
    }

    .switch-top2 {
        position: relative;
        height: 26px;
        width: 120px;
        margin: 12px 20px 0px 20px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 3px;
        -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    }

    .switch-top2-label {
        position: relative;
        z-index: 2;
        float: left;
        width: 60px;
        line-height: 26px;
        font-size: 11px;
        color: rgba(0, 0, 0, 0.35);
        text-align: center;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
        cursor: pointer;
    }
    .switch-top2-label:active {
        font-weight: bold;
    }

    .switch-top2-label-off {
        padding-left: 2px;
    }

    .switch-top2-label-on {
        padding-right: 2px;
    }

    .inactive-closers-input,
    .refunded-input,
    .no-show-input,
    .deleted-option-input {
        display: none;
    }

    .inactive-closers-input:checked + .switch-top2-label,
    .no-show-input:checked + .switch-top2-label,
    .refunded-input:checked + .switch-top2-label {
        font-weight: bold;
        color: rgba(0, 0, 0, 0.65);
        text-shadow: 0 1px rgba(255, 255, 255, 0.25);
        -webkit-transition: 0.15s ease-out;
        -moz-transition: 0.15s ease-out;
        -ms-transition: 0.15s ease-out;
        -o-transition: 0.15s ease-out;
        transition: 0.15s ease-out;
        -webkit-transition-property: color, text-shadow;
        -moz-transition-property: color, text-shadow;
        -ms-transition-property: color, text-shadow;
        -o-transition-property: color, text-shadow;
        transition-property: color, text-shadow;
    }
    .inactive-closers-input:checked + .switch-top2-label-on ~ .switch-top2-selection,
    .no-show-input:checked + .switch-top2-label-on ~ .switch-top2-selection,
    .refunded-input:checked + .switch-top2-label-on ~ .switch-top2-selection {
        left: 60px;
    }

    .inactive-closers-input:checked + .switch-top2-label-three ~ .switch-top2-selection,
    .no-show-input:checked + .switch-top2-label-three ~ .switch-top2-selection,
    .refunded-input:checked + .switch-top2-label-three ~ .switch-top2-selection {
        left: 120px;
    }

    .inactive-closers-input:checked + .switch-top2-label-off ~ .switch-top2-selection,
    .no-show-input:checked + .switch-top2-label-off ~ .switch-top2-selection,
    .refunded-input:checked + .switch-top2-label-off ~ .switch-top2-selection {
        left: 2px;
    }

    .switch-top2-selection,
    .switch-top3-selection {
        position: absolute;
        z-index: 1;
        top: 2px;
        left: 2px;
        display: block;
        width: 58px;
        height: 22px;
        border-radius: 3px;
        background-color: #65bd63;
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #9dd993), color-stop(100%, #65bd63));
        background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
        background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
        background-image: -ms-linear-gradient(top, #9dd993, #65bd63);
        background-image: -o-linear-gradient(top, #9dd993, #65bd63);
        background-image: linear-gradient(top, #9dd993, #65bd63);
        -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
        -webkit-transition: left 0.15s ease-out;
        -moz-transition: left 0.15s ease-out;
        -ms-transition: left 0.15s ease-out;
        -o-transition: left 0.15s ease-out;
        transition: left 0.15s ease-out;
    }

    .sys-message{
        position: absolute;
        top:0;
        right: 0;
    }

    .switch-top3 {
        position: relative;
        height: 26px;
        width: 300px;
        margin: 12px 20px 0px 20px;
        background: rgba(0, 0, 0, 0.25);
        border-radius: 3px;
        -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    }

    .switch-top3-label {
        position: relative;
        z-index: 2;
        float: left;
        width: 60px;
        line-height: 26px;
        font-size: 11px;
        color: rgba(0, 0, 0, 0.35);
        text-align: center;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
        cursor: pointer;
    }
    .switch-top3-label:active {
        font-weight: bold;
    }

    .switch-top3-label-one {
        padding-left: 2px;
    }

    .switch-top3-label-two,
    .switch-top3-label-three,
    .switch-top3-label-four,
    .switch-top3-label-five
    {
        padding-right: 2px;
    }

    .remind-in-input{display:none;}

    .remind-in-input:checked + .switch-top3-label{
        font-weight: bold;
        color: rgba(0, 0, 0, 0.65);
        text-shadow: 0 1px rgba(255, 255, 255, 0.25);
        -webkit-transition: 0.15s ease-out;
        -moz-transition: 0.15s ease-out;
        -ms-transition: 0.15s ease-out;
        -o-transition: 0.15s ease-out;
        transition: 0.15s ease-out;
        -webkit-transition-property: color, text-shadow;
        -moz-transition-property: color, text-shadow;
        -ms-transition-property: color, text-shadow;
        -o-transition-property: color, text-shadow;
        transition-property: color, text-shadow;
    }

    .remind-in-input:checked + .switch-top3-label-one ~ .switch-top3-selection{
        left: 2px;
    }

    .remind-in-input:checked + .switch-top3-label-two ~ .switch-top3-selection{
        left: 60px;
    }

    .remind-in-input:checked + .switch-top3-label-three ~ .switch-top3-selection{
        left: 120px;
    }

    .remind-in-input:checked + .switch-top3-label-four ~ .switch-top3-selection{
        left: 180px;
    }

    .remind-in-input:checked + .switch-top3-label-five ~ .switch-top3-selection{
        left: 240px;
    }

    #calendar-popup{
        border: 1px solid gray;
        border-radius: 5px;
        z-index:1000;
        background: white;
        position: absolute;
        right: 15px;
        top:33px;
        display: none;
    }

    #reminder-date-text{
        text-align: center;
        position: relative;
        top: -10px;
        font-size: 9pt;
    }

</style>
