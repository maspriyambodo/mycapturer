<div class="card card-custom">
    <div class="card-body">
        <div class="row">
            <?php
            foreach ($result as $value) {
                if ($value->icon) {
                    $icon = $value->icon;
                } else {
                    $icon = 'fas fa-bars';
                }
                if ($value->link == 'javascrip:;') {
                    $link = 'javascript:void(0);';
                } else {
                    $link = base_url($value->link);
                }
                ?>
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-10">
                        <div class="symbol symbol-40 mr-5">
                            <span class="symbol-label">
                                <i class="<?php echo $icon; ?>"></i>
                            </span>
                        </div>
                        <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                            <a href="<?php echo $link; ?>" class="text-dark text-hover-primary mb-1 font-size-lg"><?php echo $value->menu_nama; ?></a>
                            <span class="text-muted"><?php echo $value->grup_nama; ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>