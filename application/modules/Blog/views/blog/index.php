<link href="<?php echo base_url('assets/css/blog.css'); ?>" rel="stylesheet" type="text/css"/>
<section id="content" class="section-1 single featured bg-white">
    <div class="container-xl" style="max-width:fit-content !important;">
        <div class="row">
            <?php
            if ($this->uri->segment(3) == 'Category') {
                echo '<h3>Category: ' . Post_get('q') . '</h3>';
            } elseif ($this->uri->segment(3) == 'Tags') {
                echo '<h3>Post Tags: ' . Post_get('q') . '</h3>';
            } elseif ($this->uri->segment(3) == 'Post') {
                echo '<h3>Search: ' . Post_get('searchtxt') . '</h3>';
            } else {
                null;
            }
            ?>
            <div class="mb-4" style="border-bottom: 1px dashed #e2e2e2;width:100%;"></div>
            <main class="col-12 col-lg-8 p-0">
                <div class="blogposts-wrap">
                    <div class="blog-lists-blog clearfix">
                        <div class="blogposts-tp-site-wrap clearfix" id="themepacific_infinite">
                            <?php
                            foreach ($post as $post) {
                                $syscreatedate = new DateTime($post->syscreatedate);
                                $stringDate = $syscreatedate->format('Y F d');
                                $post_title = str_replace(['!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '#', '[', ']', ' ', '"'], ['%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D', '%20', '%22'], $post->post_title);
                                ?>
                                <div class="blogposts-inner">
                                    <ul>	 		
                                        <li class="full-left clearfix">	
                                            <div class="magbig-thumb">
                                                <?php
                                                if (!empty($post->post_thumbnail)) {
                                                    echo '<a href="' . base_url('Blog/Read/' . $post_title) . '" title="' . $post->post_title . '" class="post-thumbnail">'
                                                    . '<img src="' . base_url('assets/images/blog/thumb/' . $post->post_thumbnail) . '" alt="' . $post->post_title . '">'
                                                    . '</a>';
                                                } else {
                                                    echo '<a href="' . base_url('Blog/Read/' . $post_title) . '" title="' . $post->post_title . '" class="post-thumbnail">'
                                                    . '<img src="' . base_url('assets/images/blog/thumb/no_pict.png') . '" alt="' . $post->post_title . '">'
                                                    . '</a>';
                                                }
                                                ?>
                                            </div>
                                            <div class="list-block">
                                                <h1>
                                                    <a href="<?php echo base_url('Blog/Read/' . $post_title); ?>" title="<?php echo $post->post_title; ?>">
                                                        <?php echo str_replace('*', '/', $post->post_title); ?>
                                                    </a>
                                                </h1>
                                                <div class="post-meta-blog">
                                                    <span class="meta_author">
                                                        <a href="javascript:void();" title="Posts by <?php echo $post->nama; ?>" rel="author"><?php echo $post->nama; ?></a>
                                                    </span>
                                                    <span class="meta_date"> <?php echo $stringDate; ?></span>
                                                </div>
                                                <div class="maga-excerpt clearfix">
                                                    <?php echo $post->post_content; ?>...
                                                    <div class="themepacific-read-more mt-4">
                                                        <a class="tpcrn-read-more" href="<?php echo base_url('Blog/Read/' . $post_title); ?>">Read more&nbsp;»</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li></ul>
                                    <br class="clear">		
                                </div>
                            <?php } echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </main>
            {sidebar}
        </div>
    </div>
</section>