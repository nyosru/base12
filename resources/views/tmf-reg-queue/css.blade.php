<style>
    html,body{height: 100%}
    body{background: #eee}

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

    .display-setting,
    .refunded-input,
    .no-show-input,
    .deleted-option-input {
        display: none;
    }

    .display-setting:checked + .switch-top2-label,
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
    .display-setting:checked + .switch-top2-label-on ~ .switch-top2-selection,
    .no-show-input:checked + .switch-top2-label-on ~ .switch-top2-selection,
    .refunded-input:checked + .switch-top2-label-on ~ .switch-top2-selection {
        left: 60px;
    }

    .display-setting:checked + .switch-top2-label-three ~ .switch-top2-selection,
    .no-show-input:checked + .switch-top2-label-three ~ .switch-top2-selection,
    .refunded-input:checked + .switch-top2-label-three ~ .switch-top2-selection {
        left: 120px;
    }

    .display-setting:checked + .switch-top2-label-off ~ .switch-top2-selection,
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



    #search-results-block{max-height: 450px;overflow-x: auto;overflow-y: auto;}

    #tms-area{display: none;}
    #tms-list{display: inline-block;overflow: hidden auto;}
    .trademark{width: 320px;overflow-wrap: break-word;height: 100px;padding: 0.32rem}
    .country-flag{width:61px;}
    .client{width: 260px;overflow-wrap: break-word}
    .since-last-action{width: 55px;text-align: center}
    .time-since,.pending-in{width:165px;}

    .numbers-block{white-space: nowrap}

    .item-table{background: white}

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-left: .1rem;
        margin-right: .1rem;
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

    #preview{
        position:absolute;
        border:1px solid #ccc;
        background:#333;
        padding:5px;
        display:none;
        color:#fff;
        z-index: 100;
    }

    @keyframes show_selected_row {

        from {background-color: white;}
        to {background-color: orange;}
    }

</style>
