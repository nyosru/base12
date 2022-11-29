<style>
    html,body{height: 100%}
    body{background: #eee}

    .filter-block{display: none}

    .curtain{
        background: rgba(255,229,201,0.3);
        z-index: 2000000;
        border: 3px dashed #ccc;
        position: absolute;
        text-align: center;
        display: none;
    }

    .legend-point{
        display: inline-block;
        width: 13px;
        height: 13px;
        border-radius: 10px;
        position: absolute;
        top: 16px;
        left: 3px;
    }

    .lp-boom{background: green}
    .lp-noshow{background: brown}
    .lp-jth{background: yellow}
    .lp-future-booking{background: magenta}
    .lp-booking-noboom{background: red}
    .lp-filtered{background: black}

    .curtain-message-block{
        background: red;
        display: inline-block;
        padding: 20px;
        color: white;
        font-weight: 600;
        margin-top: 40%;
        width: 400px;
        text-align: center;
    }

    .pq-application{cursor: pointer}
    .pq-application:hover{background: orange}

    #myTabContent{overflow-x: hidden;overflow-y: auto}
    #client-data{display: none}

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
