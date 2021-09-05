<?php
$old_token = $this->bodo->Dec(Post_get('token'));
$new_token = Enkrip($old_token);
?>
<div class="card card-custom">
    <form action="<?php echo base_url('Compro/Gallery/Update?token=' . Post_get('token')); ?>" method="post">
        <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
        <input type="hidden" name="tokentxt" value="<?php echo $new_token; ?>"/>
        <input type="hidden" name="old_lowres" value="<?php echo $data[0]->lowres; ?>"/>
        <input type="hidden" name="old_highres" value="<?php echo $data[0]->highres; ?>"/>
        <input type="hidden" name="old_title" value="<?php echo $data[0]->title; ?>"/>
        <textarea name="old_deskripsi" style="display: none;"><?php echo $data[0]->desc; ?></textarea>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="titletxt">Title:</label>
                        <input type="text" class="form-control" id="titletxt" name="titletxt" required="" autocomplete="off" maxlength="100" value="<?php echo $data[0]->title; ?>"/>
                        <input type="hidden" name="thumbnail_txt"/>
                        <input type="hidden" name="highres_txt"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipetxt">Type:</label>
                        <select id="tipetxt" name="tipetxt" class="form-control custom-select" required="" onchange="Tipetxt(this.value)">
                            <?php
                            $yt_param = explode("v=", $data[0]->highres);
                            if ($data[0]->tipe == 1) {
                                $tipe_1 = 'selected=""';
                                $tipe_2 = null;
                                $tipe_3 = null;
                                $hires = '<figure class="figure">'
                                        . '<img id="hires_img" src="' . base_url('assets/images/portfolio/highres/' . $data[0]->highres) . '" class="figure-img img-fluid rounded" alt="' . $data[0]->title . '" />'
                                        . '</figure>';
                            } elseif ($data[0]->tipe == 2) {
                                $tipe_1 = null;
                                $tipe_2 = 'selected=""';
                                $tipe_3 = null;
                                $hires = '<div class="ratio ratio-4x3">'
                                        . '<iframe src="' . base_url('assets/images/portfolio/highres/' . $data[0]->highres) . '" title="' . $data[0]->title . '" allowfullscreen></iframe>'
                                        . '</div>';
                            } elseif ($data[0]->tipe == 3) {
                                $tipe_1 = null;
                                $tipe_2 = null;
                                $tipe_3 = 'selected=""';
                                $hires = '<iframe width="100%" height="350" src="https://www.youtube.com/embed/' . $yt_param[1] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                            } else {
                                $tipe_1 = null;
                                $tipe_2 = null;
                                $tipe_3 = null;
                                $hires = null;
                            }
                            ?>
                            <option value="">Choose type</option>
                            <option value="1" <?php echo $tipe_1; ?>>Image</option>
                            <option value="2" <?php echo $tipe_2; ?>>Video (Upload)</option>
                            <option value="3" <?php echo $tipe_3; ?>>Video (YouTube)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="thmbtxt">Image Thumbnail:</label>
                        <figure class="figure">
                            <img id="thmb_img" src="<?php echo base_url('assets/images/portfolio/' . $data[0]->lowres); ?>" class="figure-img img-fluid rounded" alt="<?php echo $data[0]->title; ?>"/>
                        </figure>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="highres">High Resolution:</label>
                        <?php
                        echo $hires;
                        ?>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="desctxt">Description:</label>
                        <textarea id="desctxt" class="form-control" name="desctxt" required=""><?php echo $data[0]->desc; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="<?php echo base_url('Compro/Gallery/index/'); ?>" class="btn btn-default"><i class="fas fa-undo-alt"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
            </div>
        </div>
    </form>
</div>
<script>
    window.onload = function () {

    };
</script>