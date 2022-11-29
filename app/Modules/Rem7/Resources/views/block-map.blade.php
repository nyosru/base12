
{{-- <!-- Map Section Start --> --}}
<div class="map1" id="yamap">
    {{-- <div class="container-fluid">
            <script type="text/javascript" charset="utf-8" async
                        src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ad9f8eee381a4bdc7931db15c02301cc9ac9642b91155ceefcc96dbe9dc2bae45&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true">
            </script>
        </div> --}}
    {{-- 1111111 map 11111111 --}}
</div>
{{-- <!-- Map Section End --> --}}

@section('script')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {

            // $(window).bind("load", function() {
            var $show55 = 11;

            $(window).scroll(function() {

                if ($show55 != 22) {

                    var wt = $(window).scrollTop();
                    var wh = $(window).height();
                    var et = $('#yamap').offset().top - 1500;
                    var eh = $('#yamap').outerHeight();
                    var dh = $(document).height();

                    if (wt + wh >= et || wh + wt == dh || eh + et < wh) {

                        $show55 = 22;
                        // alert('2222222222');
                        console.log('load map');
                        showYaMaps();

                    }
                }

            });

            function showYaMaps() {
                var script = document.createElement("script");
                script.type = "text/javascript";
                script.src =
                    "https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ad9f8eee381a4bdc7931db15c02301cc9ac9642b91155ceefcc96dbe9dc2bae45&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true";
                document.getElementById("yamap").appendChild(script);
            }

            // window.setTimeout(showYaMaps, 3000);

            // });
        });
    </script>
@endsection
