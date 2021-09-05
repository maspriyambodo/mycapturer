<div class="text-center">
    <h5>Related Post:</h5>
</div>
<div class="row">
    <?php
    foreach ($asside_related as $asside_related) {
        $post_title = str_replace(['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], ['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], $asside_related->post_title);
        ?>
        <div class="col-md-6">
            <div class="blog-list-small">
                <div class="sb-post-thumbnail">
                    <a href="<?php echo base_url('Blog/Read/' . $post_title); ?>" class="post-thumbnail" title="<?php echo $asside_related->post_title; ?>">
                        <img src="<?php echo base_url('assets/images/blog/thumb/' . $asside_related->post_thumbnail); ?>" class="attachment-sb-post-thumbnail size-sb-post-thumbnail wp-post-image" alt="<?php echo $asside_related->post_title; ?>" loading="lazy" title="<?php echo $asside_related->post_title; ?>" srcset="<?php echo base_url('assets/images/blog/thumb/' . $asside_related->post_thumbnail); ?>" sizes="(max-width: 70px) 100vw, 70px" width="70" height="70">
                    </a>
                </div>
                <div class="blog-lists-title">   
                    <h3>
                        <a href="<?php echo base_url('Blog/Read/' . $post_title); ?>" title="<?php echo $asside_related->post_title; ?>">
                            <?php echo $asside_related->post_title; ?>
                        </a>
                    </h3>
                </div> 
            </div>
        </div>
    <?php } ?>
</div>