<div class="container">
    <div class="row">
        <div class="col-lg-6 align-self-center wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.25s">
            <div class="section-heading">

                <h2>Отправте свой телефон</h2>
                <p>Мы Вам перезвоним уточнить детали и рассказать что да как и как лучше сделать</p>

                <div class="phone-info">
                    <h4>Или просто позвоните: <span><a href="tel:+79698109056"><i class="fa fa-phone"></i></a> <a
                                href="tel:+79698109056">8-969-810-90-56</a></span></h4>
                </div>

            </div>
        </div>
        <div class="col-lg-6 wow fadeInRight" data-wow-duration="0.5s" data-wow-delay="0.25s">
            <form id="contact" action="" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <fieldset>
                            <input type="name" name="name" id="name" placeholder="Как Вас зовут" autocomplete="on"
                                required>
                        </fieldset>
                    </div>

                    <div class="col-lg-6">
                        <fieldset>
                            <input type="text" name="phone" id="phone" placeholder="Телефон" autocomplete="on" required>
                        </fieldset>
                    </div>

                    {{-- <div class="col-lg-12">
                        <fieldset>
                            <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email" required="">
                        </fieldset>
                    </div> --}}

                    <div class="col-lg-12">
                            <a onclick="$('#we').toggle('slow'); $(this).hide(); return false;" href="#" style="margin: 20px 0;" >Добавить
                                комментарий, файлы</a>
                    </div>

                    <div style="display:none;" id="we">

                        <div class="col-lg-12">
                            <fieldset>
                                <textarea name="message" type="text" class="form-control" id="message"
                                    placeholder="Сообщение"></textarea>
                            </fieldset>
                        </div>

                        <div class="col-lg-6">
                            <input type="file" name="file[]">
                            <br />
                            <input type="file" name="file[]">
                        </div>
                        <div class="col-lg-6">
                            <input type="file" name="file[]">
                            <br />
                            <input type="file" name="file[]">
                        </div>

                    </div>
                    <div class="col-lg-12">

                        <fieldset>
                            <button type="submit" id="form-submit" class="main-button ">Отправить</button>
                        </fieldset>

                    </div>
                </div>
                <div class="contact-dec">
                    <img src="{{ asset('/kadastr/assets/images/contact-decoration.png') }}" alt="">
                </div>
            </form>
        </div>
    </div>
</div>
