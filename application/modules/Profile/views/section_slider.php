<?php $compro = $this->bodo->Compro(); ?>
<section id="slider" class="hero odd p-0">
    <div class="swiper-container full-slider featured animation slider-h-100">
        <div class="swiper-wrapper">

            <div class="swiper-slide slide-center">
                <img class="full-image" data-aos="zoom-out-up" data-aos-delay="800" src="<?php echo base_url('assets/images/portfolio/highres/portfolio_1.jpg'); ?>" alt="Hero Image">
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
            <div class="swiper-slide slide-center">
                <img class="full-image" data-aos="zoom-out-up" data-aos-delay="800" src="<?php echo base_url('assets/images/portfolio/highres/portfolio_2.jpg'); ?>" alt="Hero Image">
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
        <div class="swiper-pagination"></div>
    </div>
</section>