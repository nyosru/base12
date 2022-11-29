{{-- <!-- Owl Slider Section Start --> --}}
<section class="sloder-img section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="slider-center slider">
                    <div>
                        <img class="img-fluid" src="{{ asset('/module_rem7/img/slide/img1.jpg') }}" alt="">
                    </div>
                    <div>
                        <img class="img-fluid" src="{{ asset('/module_rem7/img/slide/img2.jpg') }}" alt="">
                    </div>
                    <div>
                        <img class="img-fluid" src="{{ asset('/module_rem7/img/slide/img3.jpg') }}" alt="">
                    </div>
                    <div>
                        <img class="img-fluid" src="{{ asset('/module_rem7/img/slide/img4.jpg') }}" alt="">
                    </div>
                    <div>
                        <img class="img-fluid" src="{{ asset('/module_rem7/img/slide/img5.jpg') }}" alt="">
                    </div>
                    <div>
                        <img class="img-fluid" src="{{ asset('/module_rem7/img/slide/img6.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <!-- Owl Slider Section End --> --}}


@section('script')
    @parent

    {{-- <script src="{{ asset('/module_rem7/js/slick.min.js') }}"></script> --}}

    <script type="text/javascript">
        $(document).ready(function() {
            /* вся мaгия пoслe зaгрузки стрaницы */

            /*  Slick Slider
            ========================================================*/
            $('.slider-center').slick({
                centerMode: true,
                centerPadding: '60px',
                slidesToShow: 3,
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>

    {{-- <script src="{{ asset('/module_rem7/js/jquery.slicknav.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            /* вся мaгия пoслe зaгрузки стрaницы */

            /* slicknav mobile menu active  */
            $('.mobile-menu').slicknav({
                prependTo: '.navbar-header',
                parentTag: 'liner',
                allowParentLinks: true,
                duplicate: true,
                label: '',
                closedSymbol: '<i class="lni-chevron-right"></i>',
                openedSymbol: '<i class="lni-chevron-down"></i>',
            });

        });
    </script> --}}

@endsection
