<style>
    @font-face {
        font-family: Barlow Semi Condensed;
        src: url(/fonts/BarlowSemiCondensed-ExtraBold.eot);
        src: url(/fonts/BarlowSemiCondensed-ExtraBold.eot?#iefix) format("embedded-opentype"),
        url(/fonts/BarlowSemiCondensed-ExtraBold.woff) format("woff"),
        url(/fonts/BarlowSemiCondensed-ExtraBold.ttf) format("truetype");
        font-weight: 800;
        font-style: normal;
        font-display: swap;
    }
    @font-face {
        font-family: Barlow Semi Condensed;
        src: url(/fonts/BarlowSemiCondensed-Regular.eot);
        src: url(/fonts/BarlowSemiCondensed-Regular.eot?#iefix) format("embedded-opentype"),
        url(/fonts/BarlowSemiCondensed-Regular.woff) format("woff"),
        url(/fonts/BarlowSemiCondensed-Regular.ttf) format("truetype");
        font-weight: 200;
        font-style: normal;
        font-display: swap;
    }

    @font-face{
        font-family:'SalvoSans';
        src:url('/fonts/SalvoSans-Light.eot');
        src:url('/fonts/SalvoSans-Light.eot?#iefix') format('embedded-opentype'),
        url('/fonts/SalvoSans-Light.woff') format('woff'),
        url('/fonts/SalvoSans-Light.ttf') format('truetype');font-weight:300;font-style:normal;
        font-display: swap;
    }

    @font-face{

        font-family:'SalvoSans';
        src:url('fonts/SalvoSans-Bold.eot');
        src:url('fonts/SalvoSans-Bold.eot?#iefix') format('embedded-opentype'),
        url('fonts/SalvoSans-Bold.woff') format('woff'),
        url('fonts/SalvoSans-Bold.ttf') format('truetype');font-weight:bold;font-style:normal
        font-display: swap;
    }

    @font-face {
        font-family: futura_ltcondensedextrabold;
        src: url("fonts/Futura Condensed Extra Bold.otf") format("opentype");
        font-display: swap;
    }

    .faqcartoon-header-container{margin-top: 50px;}

    .faqcartoon-header-container h2.header-h2{font-family: futura_ltcondensedextrabold !important; font-weight: 900!important; text-transform: uppercase; font-size: 55px!important; color: #020c44; letter-spacing: -3px; line-height: 55px!important; text-align: left; position: relative; margin: 0 0 50px; padding: 0 0 55px;text-align: center}
    .faqcartoon-header-container h2 span{display: block;}
    .faqcartoon-header-container h2.header-h2 small{font-family: 'SalvoSans'; display:block; font-weight: 300; font-size: 23px; color: #0d0142; letter-spacing: 4px; padding:0 0 30px;}
    .faqcartoon-header-container h2.header-h2::after{content: ""; width: 80px; height: 4px; background: rgb(67, 40, 183); position: absolute;left: 0;bottom: 0;right: 0;margin: auto;}


    #columns-container{
        max-width: 1000px;
        margin: auto;
        text-align: left;
    }

    #accordion0,
    #accordion1{
        max-width: 500px;
    }

    #accordion0{
        float: right;
    }

    #accordion1{
        float: left;
    }

    .panel{
        box-shadow: 3px 3px 5px rgba(0,0,0,0.5);
    }

    .show-all-items{
        color: black;
        font-weight: bold;
    }

    .form-control{
        width: 100% !important;
    }

    #search-input{
        padding: 15px 10px 15px 10px;
        /*max-width: 650px;*/
        /*margin: auto;*/
    }

    #search-results{
        border-radius: 0;
        text-align: left;
    }

    #search-container{
        max-width: 500px;
        margin: auto;
    }

    #search-container .fa {
        float: right;
        margin-right: 1em;
        margin-top: -2em;
        font-size: 1.25em;
        position: relative;
        z-index: 2;
        color: grey;
    }

    .search-result-item{
        font-size: 16px;
    }

    .item-link{
        font-size: 13pt;
    }

    /** Smartphones **/
    @media (min-width: 320px) and (max-width: 480px) {

        .faqcartoon-header-container h2.header-h2{font-size: 27px!important; line-height: 27px!important; letter-spacing: 0; text-align: center;}
        .faqcartoon-header-container h2.header-h2::after{right:0; margin:auto;}
    }

    /* Smartphones to Tablets */
    @media (min-width: 481px) and (max-width: 767px) {
        .faqcartoon-header-container{margin-top: 80px;}
        .faqcartoon-header-container h2.header-h2{font-size: 27px!important; line-height: 27px!important; letter-spacing: 0; text-align: center;}
        .faqcartoon-header-container h2.header-h2::after{right:0; margin:auto;}
    }

    /* Tablets */
    @media (min-width: 768px) and (max-width: 959px) {
        .faqcartoon-header-container h2.header-h2{font-size: 45px!important; line-height: 45px!important; letter-spacing: -1px; text-align: center;}
        .faqcartoon-header-container h2.header-h2::after{right:0; margin:auto;}
    }

    /* Desktop */
    @media (min-width: 960px) and (max-width: 1090px) {
        .faqcartoon-header-container h2.header-h2{font-size: 45px!important; line-height: 45px!important; letter-spacing: -1px; text-align: center;}
        .faqcartoon-header-container h2.header-h2::after{right:0; margin:auto;}
    }


    @media only screen and (max-width: 1024px) {
        .faqcartoon-header-container{margin-top: 130px;}
    }

    @media only screen and (max-width: 825px) {
        #left-column,
        #right-column{
            width: 100% !important;
        }

        #accordion0,
        #accordion1{
            /*max-width: 100%;*/
            float: unset;
            margin: auto;
        }
    }

    @media only screen and (max-width: 595px) {
        #search-container{
            max-width: 100%;
        }
    }

    /*    .fa-search:before {
            content: "\f002";
        }*/

</style>
