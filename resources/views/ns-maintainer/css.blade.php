<style>
    #yt-filter{
        width: 200px;
    }

    .note-editable * {
        line-height: inherit !important;
        font-size: 14px !important;
        font-family: 'Open Sans';
    }

    .accordion > .card {
        overflow: unset;
    }

    .visibility-option-input {
        display: none;
    }

    .visibility-option-input:checked + .switch-top-label {
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

    .visibility-option-input:checked + .switch-top-label-on ~ .switch-top-selection {
        left: 60px;
    }

    .visibility-option-input:checked + .switch-top-label-three ~ .switch-top-selection {
        left: 120px;
    }

    .visibility-option-input:checked + .switch-top-label-off ~ .switch-top-selection {
        left: 2px;
    }

    .switch-top {
        position: relative;
        height: 26px;
        width: 180px;
        margin: 0;
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
        padding-left: 2px;
    }

    .switch-top-label-on {
        padding-right: 2px;
    }

    .switch-top-label-three {
        padding-right: 2px;
    }

    .switch-top-input,
    .switch-ready-input {
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
</style>