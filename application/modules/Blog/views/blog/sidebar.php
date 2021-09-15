<aside class="col-12 col-lg-4 pl-lg-5 p-0 float-right sidebar" style="border-left: 1px dashed #e2e2e2;">
    <div class="row">
        <div class="col-12 align-self-center text-left">
            <h4 class="title">Popular <i class="fas fa-fire-alt text-danger"></i></h4>
            <div class="item widget-categories">
                <script async custom-element="amp-auto-ads"
                        src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js">
                </script>
                <ul class="list-group list-group-flush">
                    <?php
                    foreach ($asside_popular as $asside_popular) {
                        $post_title = str_replace(['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], ['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], $asside_popular->post_title);
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?php echo base_url('Blog/Read/' . $post_title); ?>">
                                <?php echo $asside_popular->post_title; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>   
            </div>
            <h4 class="title">Recent</h4>
            <div class="item widget-categories">
                <ul class="list-group list-group-flush">
                    <?php
                    foreach ($asside_recent as $asside_recent) {
                        $recent_title = str_replace(['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], ['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], $asside_recent->post_title);
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?php echo base_url('Blog/Read/' . $recent_title); ?>">
                                <?php echo $asside_recent->post_title; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul> 
            </div>
            <h4 class="title">Categories</h4>
            <div id="widget-categories" class="item widget-categories">
                <ul class="list-group list-group-flush">
                    <?php
                    foreach ($asside_category as $asside_category) {
                        $category = str_replace(['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], ['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], $asside_category->category);
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="<?php echo base_url('Blog/Search/Category/?q=' . $category); ?>">
                                <?php echo $asside_category->category; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>                                
            </div>
            <div class="item widget-tags">  
                <h4 class="title">Popular Tags</h4>
                <?php
                foreach ($asside_tags as $key => $popular_tags) {
                    $tags = str_replace(['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], ['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], $asside_tags[$key]);
                    ?>
                    <a href="<?php echo base_url('Blog/Search/Tags/?q=' . $tags); ?>" class="badge tag"><?php echo $popular_tags; ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</aside>