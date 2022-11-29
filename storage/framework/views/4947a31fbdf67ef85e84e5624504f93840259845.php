<?php $__env->startSection('content'); ?>

    <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6 align-self-center">
                            <div class="left-content header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">

                                <h6>Добро пожаловать</h6>

                                <h2>Мы делаем <em>всё связанное</em> с&nbsp;<span>Земельным Кадастром</span> и&nbsp;всякими
                                    планами</h2>
                                <p>
                                    Быстро и понятно оказываем услуги по планированию, узаканиванию изменений и фиксированию
                                    текущих планов и будующих построек
                                    
                                </p>

                                <center>
                                    <a href="#contact" class="btn btn-success">Заказать обратный звонок</a>
                                    <a href="#contact" class="btn btn-info">Отправить заявку</a>
                                </center>

                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-image wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.5s">
                                <img src="<?php echo e(asset('/kadastr/SpaceDynamic/assets/images/banner-right-image.png')); ?>"
                                    alt="team meeting">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="about" class="about-us section">
        <?php echo $__env->make('kadastr::block-about', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div id="services" class="our-services section">
        
        <?php echo $__env->make('kadastr::block-services2', [ '$uslugi' => $uslugi ] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <?php if( 1 == 2 ): ?>
    <div id="portfolio" class="our-portfolio section">
        <?php echo $__env->make('kadastr::block-portfolio', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php endif; ?>

    <?php if( 1 == 2 ): ?>
    <div id="blog" class="our-blog section">
        <?php echo $__env->make('kadastr::block-blog', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <?php endif; ?>

    <div id="contact" class="contact-us section">
        <?php echo $__env->make('kadastr::block-contact', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('kadastr::app.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/base12/data/www/site/app/Modules/Kadastr/Resources/views/page-index.blade.php ENDPATH**/ ?>