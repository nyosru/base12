@section('breadcrumbs')
    <li><a href="/contact/">Контакты</a></li>
    {{-- <li><a href="#">Contact us</a></li> --}}
@endsection


@section('content-head')
    Контакты
@endsection

<h3>Салон-магазин &quot;В мире бильярда&quot;</h3>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="wrp">
                <div class="map-box">
                    <div>
                        <p>
                            <b>В&nbsp;мире&nbsp;бильярда</b>
                            <br />
                            салон-магазин
                            <br />
                            ( ООО&nbsp;&quot;ЛТАВА&quot; )
                            <br />
                            <br />
                            г.Тюмень,
                            <br />
                            ул.Республики 207
                            <br />
                            офис 110
                            <br />
                            <br />
                            E-mail: <a href="mailto:ltawa@mail.ru">ltawa@mail.ru</a>
                            <br />
                            {{-- </p> --}}

                            {{-- <p>
                    <a href="http://www.youtube.com/channel/UCxppGVX4IDy3tQP-pLSjc4w/feed" target="_blank"><img alt=""
                            src="/img/icon/heart.png"
                            style="border-style:solid; border-width:0px; height:24px; width:24px" /> Видео канал youtube
                        о игре на бильярде</a>
                </p>
                <p>
                    <a target="_blank" href="{$sd}ltawa.pdf"><img alt="" src="/image/icon/pdf.png"
                            style="height:35px; width:35px" />
                        карточка предприятия
                    </a>
                </p> --}}
                            {{-- <p> --}}
                            {{-- <br /> --}}
                            {{-- <br /> --}}
                            {{-- Позвоните нам: --}}
                            {{-- <br /> --}}
                            {{-- <br /> --}}
                            {{-- (3452) 49-14-42<br /> --}}
                            {{-- (3452) 61-47-37<br /> --}}
                            Тел: <a href="tel:+79091800645">8-909-180-06-45</a>
                            {{-- <br /> --}}
                            {{-- 8(909)736-39-50 --}}
                        </p>

                    </div>
                </div>

                {{-- </div><div class="col-12 col-sm-6"> --}}
                <script type="text/javascript" charset="utf-8" async
                                src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Acd2f2092874c87a2f8d3a38021d1f9ed273b775d696fbc92bde8b5ea85c14ddd&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=true">
                </script>

            </div>
        </div>
    </div>
</div>

<style>
    .wrp {
        max-width: 100%;
        margin: 0 auto;
        position: relative;
    }

    .map-box {
        position: absolute;
        text-align: center;
        top: 70px;
        left: 5vw;
        padding: 0;
        background: #fff;
        background-image: url('billiard/img/bg1.jpg');
        background-size: 90%;
        border: 1px solid #ddd;
        border-radius: 3%;
        overflow: hidden;
        z-index: 100;
        width: 250px;
        box-shadow: -1px -1px 24px 0px rgba(50, 50, 50, 0.5);
    }

    .map-box div {
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.9);
    }

</style>
