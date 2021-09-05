<?php
$compro = $this->bodo->Compro();
?>
<section id="contacts" class="section-1 offers">
    <div class="container">
        <div class="row intro">
            <div class="col-12 col-md-9 align-self-center text-center text-md-left">
                <h2 class="featured">How Can We Help?</h2>
                <p>
                    Talk to one of our consultants today and learn how to start leveraging your business.
                </p>
            </div>
            <div class="col-12 col-md-3 align-self-end">

            </div>
        </div>
        <div class="row justify-content-center text-center items">
            <?php
            if (!empty($compro['phone_company'])) {
                echo '<div class="col-12 col-md-6 col-lg-4 item">'
                . '<div class="card featured">'
                . '<i class="icon icon-phone"></i>'
                . '<h4>' . $compro['phone_company'] . '</h4>'
                . '<p class="mb-1">' . $compro['phone_description'] . '</p>'
                . '</div>'
                . '</div>';
            } else {
                null;
            }
            if (!empty($compro['mail_company'])) {
                echo '<div class="col-12 col-md-6 col-lg-4 item">'
                . '<div class="card featured">'
                . '<i class="icon icon-envelope"></i>'
                . '<h4>' . $compro['mail_company'] . '</h4>'
                . '<p class="mb-1">' . $compro['mail_description'] . '</p>'
                . '</div>'
                . '</div>';
            } else {
                null;
            }
            if (!empty($compro['alamat_company'])) {
                echo '<div class="col-12 col-md-6 col-lg-4 item">'
                . '<div class="card featured">'
                . '<i class="icon icon-location-pin"></i>'
                . '<h4>' . $compro['alamat_company'] . '</h4>'
                . '<p class="mb-1">' . $compro['alamat_description'] . '</p>'
                . '</div>'
                . '</div>';
            } else {
                null;
            }
            ?>
        </div>
    </div>
</section>
<?php
if (!empty($compro['map_location'])) {
    echo '<section id="custom" class="section-2 map">'
    . '<iframe src="' . $compro['map_location'] . '" aria-hidden="false" tabindex="0" width="600" height="450"></iframe>'
    . '</section>'
    . '<div class="clearfix my-4"></div>';
} else {
    null;
}