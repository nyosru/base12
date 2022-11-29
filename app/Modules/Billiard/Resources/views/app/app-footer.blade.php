
        <!-- Container Starts -->
        <div class="container">
            <!-- Row Starts -->
            <div class="row section">
                <!-- Footer Widget Starts -->
                <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn">
                    {{-- <h3 class="small-title">
                        About Us
                    </h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis veritatis eius porro modi hic.
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </p>
                    <div class="social-footer">
                        <a href="#"><i class="fa fa-facebook icon-round"></i></a>
                        <a href="#"><i class="fa fa-twitter icon-round"></i></a>
                        <a href="#"><i class="fa fa-linkedin icon-round"></i></a>
                        <a href="#"><i class="fa fa-google-plus icon-round"></i></a>
                    </div> --}}
                </div>
                <!-- Footer Widget Ends -->

                <!-- Footer Widget Starts -->
                <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn" data-wow-delay=".2s">
                    {{-- <h3 class="small-title">
                        Links
                    </h3>
                    <ul class="menu">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Works</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul> --}}
                </div>
                <!-- Footer Widget Ends -->

                <!-- Footer Widget Starts -->
                <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn" data-wow-delay=".5s">
                    {{-- <h3 class="small-title">
                        GALLERY
                    </h3>
                    <div class="plain-flicker-gallery">
                        <a href="#"><img src="{{ asset('/billiard/img/flicker/img1.jpg') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('/billiard/img/flicker/img2.jpg') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('/billiard/img/flicker/img3.jpg') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('/billiard/img/flicker/img4.jpg') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('/billiard/img/flicker/img5.jpg') }}" alt=""></a>
                        <a href="#"><img src="{{ asset('/billiard/img/flicker/img6.jpg') }}" alt=""></a>
                    </div> --}}
                </div>
                <!-- Footer Widget Ends -->

                <!-- Footer Widget Starts -->
                <div class="footer-widget col-lg-3 col-md-6 col-xs-12 wow fadeIn" data-wow-delay=".8s">
                    <h3 class="small-title">
                        Бильярд рядом
                    </h3>
                    <div class="contact-us">
                        Тюмень, ул. Советская 55/8
                        <Br/>
                        <Br/>
                        Звоните: <a href="tel:+79091800645">8(909)180-06-45</a>
                        {{-- <form>
                            <div class="form-group">
                                <input type="text" class="form-control" id="exampleInputName2"
                                    placeholder="Enter your name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="exampleInputEmail2"
                                    placeholder="Enter your email">
                            </div>
                            <button type="submit" class="btn btn-common">Submit</button>
                        </form> --}}
                    </div>
                </div>
                <!-- Footer Widget Ends -->
            </div>
            <!-- Row Ends -->
        </div>
        <!-- Container Ends -->

        @if( 1 == 2 )
{{-- <img src="{{ asset('/billiard/img/icons/payment.webp') }}" alt="Image-HasTech" /> --}}
<footer class="footer-container typefooter-1">

    {{-- <!-- FOOTER TOP --> --}}
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <div class="module social_block col-md-3 col-sm-12 col-xs-12">
                        <ul class="social-block ">
                            {{-- <li class="facebook">
                                <a class="_blank" href="https://www.facebook.com/MagenTech" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li> --}}
                            {{-- <li class="twitter">
                                <a class="_blank" href="https://twitter.com/smartaddons" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li> --}}
                            {{-- <li class="rss">
                                <a class="_blank" href="#" target="_blank">
                                    <i class="fa fa-rss"></i>
                                </a>
                            </li> --}}
                            {{-- <li class="google_plus">
                                <a class="_blank" href="https://plus.google.com/u/0/+Smartaddons/posts" target="_blank">
                                    <i class="fa  fa-google-plus"></i>
                                </a>
                            </li> --}}
                            {{-- <li class="pinterest">
                                <a class="_blank" href="https://www.pinterest.com/smartaddons/" target="_blank">
                                    <i class="fa fa-pinterest"></i>
                                </a>
                            </li> --}}
                        </ul>
                    </div>



                    @if (1 == 2)
                        <div class="module news-letter col-md-9 col-sm-12 col-xs-12">
                            <div class="newsletter">
                                <div class="title-block">
                                    <div class="page-heading">SIGN UP FOR OUR NEWSLETTER</div>
                                    <div class="pre-text">
                                        Duis at ante non massa consectetur iaculis id non tellus
                                    </div>
                                </div>
                                <div class="block_content">
                                    <form method="post" name="signup" id="signup" class="btn-group form-inline signup">
                                        <div class="form-group required send-mail">
                                            <div class="input-box">
                                                <input type="email" placeholder="Your email address..." value=""
                                                    class="form-control" id="txtemail" name="txtemail" size="55">
                                            </div>
                                            <div class="subcribe">
                                                <button class="btn btn-default btn-lg" type="submit"
                                                    onclick="return subscribe_newsletter();" name="submit">
                                                    Subscribe </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- FOOTER CENTER -->
    <div class="footer-center">
        <div class="container content">
            <div class="row">

                {{-- <!-- BOX INFO --> --}}
                <div class="col-md-3 col-sm-6 col-xs-12 collapsed-block footer-links box-footer">
                    <div class="module ">
                        <div class="content-block-footer">
                            <div class="footer-logo">
                                {{-- <a href="index.html"><img src="image/demo/logos/theme_logo.png" title="Your Store" alt="Your Store"> --}}
                                <a href="/">
                                    <img src="{{ asset('/billiard/image/logo.png') }}" title="" alt="">
                                </a>
                            </div>
                            {{-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is
                                simply dummy text of the printing and typesetting industry.</p> --}}
                        </div>
                    </div>
                </div>

                {{-- <!-- BOX ACCOUT --> --}}
                <div class="col-md-3 col-sm-6 box-account box-footer">
                    <div class="module clearfix">
                        {{-- <h3 class="modtitle">My Account</h3>
                        <div class="modcontent">
                            <ul class="menu">
                                <li><a href="#">Brands</a></li>
                                <li><a href="#">Gift Certificates</a></li>
                                <li><a href="#">Affiliates</a></li>
                                <li><a href="#">Specials</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>

                {{-- <!-- BOX INFOMATION --> --}}
                <div class="col-md-3 col-sm-6 box-information box-footer">
                    <div class="module clearfix">
                        {{-- <h3 class="modtitle">Information</h3>
                        <div class="modcontent">
                            <ul class="menu">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">FAQ</a></li>
                                <li><a href="#">Pricing Tables</a></li>
                                <li><a href="#">Terms And Conditions</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>

                {{-- <!-- BOX ABOUT --> --}}
                <div class="col-md-3  col-sm-6 collapsed-block box-footer">
                    <div class="module ">
                        <h3 class="modtitle">Хороший бильярд рядом</h3>
                        <div class="modcontent">
                            <ul class="contact-address">
                                <li>
                                    <span class="fa fa-home"></span>
                                    Тюмень, ул. Советская 55/8
                                </li>
                                {{-- <li><span class="fa fa-envelope"></span> Email: <a href="#"> sales@yourcompany.com</a></li> --}}
                                <li>
                                    <span class="fa fa-phone">&nbsp;</span> Звоните:
                                    <a href="tel:+79091800645">8(909)180-06-45</a>
                                </li>
                            </ul>
                            <ul class="payment-method">
                                <li>
                                    {{-- <a title="Payment Method" href="#"> --}}
                                    <img src="{{ asset('/billiard/image/demo/cms/payment/payment-1.png') }}"
                                        alt="Payment">
                                    {{-- </a> --}}
                                </li>
                                @if (1 == 2)
                                    <li>
                                        {{-- <a title="Payment Method" href="#"> --}}
                                        <img src="{{ asset('/billiard/image/demo/cms/payment/payment-2.png') }}"
                                            alt="Payment">
                                        {{-- </a> --}}
                                    </li>
                                @endif
                                <li>
                                    {{-- <a title="Payment Method" href="#"> --}}
                                    <img src="{{ asset('/billiard/image/demo/cms/payment/payment-3.png') }}"
                                        alt="Payment">
                                    {{-- </a> --}}
                                </li>
                                @if (1 == 2)
                                    <li>
                                        {{-- <a title="Payment Method" href="#"> --}}
                                        <img src="{{ asset('/billiard/image/demo/cms/payment/payment-4.png') }}"
                                            alt="Payment">
                                        {{-- </a> --}}
                                    </li>
                                    <li>
                                        {{-- <a title="Payment Method" href="#"> --}}
                                        <img src="{{ asset('/billiard/image/demo/cms/payment/payment-5.png') }}"
                                            alt="Payment">
                                        {{-- </a> --}}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <!-- FOOTER BOTTOM --> --}}
    <div class="footer-bottom ">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    В мире бильярда © 2002-{{ date('Y') }}
                </div>
            </div>
        </div>
    </div>


</footer>
@endif
