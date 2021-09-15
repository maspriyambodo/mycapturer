<?php $compro = $this->bodo->Compro(); ?>
<section id="introduction" class="section-1 counter skills">
    <div class="container">
        <h2 class="super effect-static-text text-center"><?php echo $this->bodo->Sys('company_name'); ?></h2>
        <div class="row intro">

            <div class="col-md-6">
                <p class="text-justify">
                    <?php
                    if (!empty($compro['company_introduction'])) {
                        echo $compro['company_introduction'];
                    } else {
                        null;
                    }
                    ?>
                </p>
            </div>
            <div class="col-md-6">
                <p class="text-justify">
                    <?php
                    if (!empty($compro['company_introduction2'])) {
                        echo $compro['company_introduction2'];
                    } else {
                        null;
                    }
                    ?>
                </p>
            </div>

        </div>

    </div>
</section>
<section id="services" class="section-2 odd offers featured custom">
    <div class="container">
        <div class="row intro">
            <div class="col-12 col-md-9 align-self-center text-center text-md-left">
                <h2 class="super effect-static-text">Our Services</h2>
                <p>Focused on results we seek to raise the level of our customers.</p>
            </div>
            <div class="col-12 col-md-3 align-self-end">

            </div>
        </div>
        <div class="row justify-content-center text-center items">
            <?php
            foreach ($list_services as $list_services) {
                $id_servis = Enkrip($list_services->id_post);
                if ($list_services->id == $list_services->post_title) {
                    $nama_servis = '<h4><a href="' . base_url('Compro/Pages/index?service=' . $id_servis) . '" class="text-info">' . $list_services->nama . '</a></h4>';
                } else {
                    $nama_servis = '<h4>' . $list_services->nama . '</h4>';
                }
                ?>
                <div class="col-12 col-md-6 col-lg-4 item">
                    <div class="card featured">
                        <i class="fas fa-certificate text-info"></i>
                        <?php echo $nama_servis; ?>
                        <p class="text-justify">
                            <?php echo $list_services->desc; ?>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<section id="subscribe" class="section-5 subscribe">
    <div class="container smaller">
        <div class="row text-center intro">
            <div class="col-12">
                <h2 class="super effect-static-text">Newsletter</h2>
                <p class="text-max-800">Subscribe to our newsletter and follow our content closely. Receive news based on what has to do with you. We promise not to send promotions you don't like.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-0">
                <form action="<?php echo base_url('Profile/Newsletter/'); ?>" method="post" id="leverage-subscribe" class="row m-auto items">
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <div class="col-12 col-lg-5 m-lg-0 input-group align-self-center item"><input type="text" name="nametxt" class="form-control field-name" placeholder="Name" required="" autocomplete="off" maxlength="100"/></div>
                    <div class="col-12 col-lg-5 m-lg-0 input-group align-self-center item"><input type="email" name="emailtxt" class="form-control field-email" placeholder="Email" required="" autocomplete="off"/></div>
                    <div class="col-12 col-lg-2 m-lg-0 input-group align-self-center item"><button type="submit" class="btn primary-button w-100">SUBSCRIBE</button></div>
                    <div class="col-12 text-center"><span class="form-alert mt-5 mb-0" style="display: none;"></span></div>
                </form>
            </div>
        </div>
        <amp-ad height="320"
                type="adsense"
                data-ad-client="ca-pub-1136946608431939"
                data-ad-slot="1450085642"
                data-auto-format="rspv"
                data-full-width="">
            <div overflow=""></div>
        </amp-ad>
    </div>
</section>