<?php $compro = $this->bodo->Compro(); ?>
<section id="slider" class="hero odd p-0">
    <div class="swiper-container no-slider animation slider-h-100 swiper-container-initialized swiper-container-horizontal">
        <div class="swiper-wrapper">

            <div class="swiper-slide slide-center">
                <img class="full-image" data-aos="zoom-out-up" data-aos-delay="800" src="http://localhost/mycapturer/assets/images/portfolio/highres/portfolio_1.jpg" alt="Hero Image">
                <div class="slide-content row">
                    <div class="col-12 d-flex inner">
                        <div class="center align-self-center text-center">
                            <h1 data-aos="zoom-out-up" data-aos-delay="400" class="title effect-static-text aos-init aos-animate">
                                <?php
                                if (!empty($compro['slider_text'])) {
                                    echo $compro['slider_text'];
                                } else {
                                    null;
                                }
                                ?>
                            </h1>
                            <p data-aos="zoom-out-up" data-aos-delay="800" class="description ml-auto mr-auto aos-init aos-animate">
                                <?php
                                if (!empty($compro['sub_slider'])) {
                                    echo $compro['sub_slider'];
                                } else {
                                    null;
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</section>