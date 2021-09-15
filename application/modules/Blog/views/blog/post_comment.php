<style>
    #comments {
        position: relative;
    }
    .commentlist {
        list-style: none;
        padding-bottom: 50px;
        margin: 0 0 50px;
    }
    #reviews .commentlist > li:first-child, .commentlist > li:first-child {
        padding-top: 0;
        margin-top: 0;
    }
    .commentlist li {
        position: relative;
        margin: 30px 0 0 30px;
    }
    .comment-wrap {
        position: relative;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        padding: 20px 20px 20px 35px;
    }
    .commentlist li .comment-meta {
        float: left;
        margin-right: 0;
        line-height: 1;
    }
    .comment-avatar {
        position: absolute;
        top: 15px;
        left: -35px;
        padding: 4px;
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 50%;
    }
    .comment-avatar img {
        display: block;
        border-radius: 50%;
    }
    .comment-author small{
        font-size: 80%;
    }
    .comment-reply-link, .review-comment-ratings {
        display: block;
        position: absolute;
        top: 4px;
        left: auto;
        text-align: center;
        right: 2%;
        width: 14px;
        height: 14px;
        color: #ccc;
        font-size: 14px;
        line-height: 1;
    }
</style>
<div style="clear: both;position: relative;width:100%;margin:30px 0px 20px 0px;border-top: 1px solid #eee;"></div>
<div id="comments" class="clearfix">
    <h3 id="comments-title"><span>
            <?php
            if (!empty($post_comment['parent'])) {
                $tot_parent = count($post_comment['parent']);
                $parent = $post_comment['parent'];
            } else {
                $tot_parent = 0;
                $parent = [];
            }
            if (!empty($post_comment['childern'])) {
                $tot_childern = count($post_comment['childern']);
            } else {
                $tot_childern = 0;
            }
            $tot_comment = $tot_parent + $tot_childern;
            echo $tot_comment;
            ?>
        </span> Comments</h3>
    <ol class="commentlist clearfix px-4">
        <?php
        foreach ($parent as $comment) {
            ?>
            <li class="comment even thread-even depth-1" id="li-comment-1">
                <div id="comment-1" class="comment-wrap clearfix">
                    <div class="comment-meta">
                        <div class="comment-author vcard">
                            <span class="comment-avatar clearfix">
                                <img alt="<?php echo $comment->comment_user; ?>" src="http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60" class="avatar avatar-60 photo avatar-default" width="60" height="60"/>
                            </span>
                        </div>
                    </div>
                    <div class="comment-content clearfix">
                        <div class="comment-author pl-2">
                            <?php echo $comment->comment_user; ?>
                            <br>
                            <small> 
                                <?php
                                $syscreatedate = new DateTime($comment->comment_date);
                                $stringDate = $syscreatedate->format('Y F d H:i:s');
                                echo $stringDate;
                                ?>
                            </small>
                        </div>
                        <p>
                            <?php echo $comment->comment_content; ?>
                        </p>
                        <a class="comment-reply-link smooth-anchor" href="#rep_comment" onclick="Rep_comment('<?php echo Enkrip($comment->id); ?>')"><i class="fas fa-reply"></i></a>
                    </div>
                </div>
                <?php
                if (!empty($post_comment['childern'])) {
                    for ($i = 0; $i < $tot_comment; $i++) {
                        if (!empty($post_comment['childern'][$i]) and ($post_comment['childern'][$i]->comment_parent == $comment->id)) {
                            $child_comentdate = new DateTime($post_comment['childern'][$i]->comment_date);
                            $child_date = $child_comentdate->format('Y F d H:i:s');
                            echo '<ul class="children">'
                            . '<li class="comment byuser comment-author-_smcl_admin odd alt depth-2" id="li-comment-3">'
                            . '<div id="comment-3" class="comment-wrap clearfix">'
                            . '<div class="comment-meta">'
                            . '<div class="comment-author vcard">'
                            . '<span class="comment-avatar clearfix">'
                            . '<img alt="' . $post_comment['childern'][$i]->comment_user . '" src="http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60" class="avatar avatar-40 photo" width="40" height="40">'
                            . '</span>'
                            . '</div>'
                            . '</div>'
                            . '<div class="comment-content clearfix">'
                            . '<div class="comment-author pl-2">'
                            . $post_comment['childern'][$i]->comment_user
                            . '<br><small>'
                            . $child_date
                            . '</small>'
                            . '</div>'
                            . '<p>' . $post_comment['childern'][$i]->comment_content . '</p>'
                            . '<a class="comment-reply-link smooth-anchor" href="#rep_comment" onclick="Rep_comment(\'' . Enkrip($post_comment['childern'][$i]->id) . '\')"><i class="fas fa-reply"></i></a>'
                            . '</div>'
                            . '</div>'
                            . '</li>'
                            . '</ul>';
                        } else {
                            null;
                        }
                    }
                } else {
                    null;
                }
                ?>
                <div class="clear"></div>
            </li>
        <?php } ?>
    </ol>
</div>
<script>
    function Rep_comment(id) {
        $('textarea[name="message"]').val('');
        $('input[name="comment_parent"]').val('');
        $.ajax({
            url: "<?php echo base_url('Blog/get_comment?key='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('textarea[name="message"]').val('@' + data.comment_user);
                if (data.comment_parent != 0) {
                    $('input[name="comment_parent"]').val(data.comment_parent);
                } else {
                    $('input[name="comment_parent"]').val(data.id);
                }
            }
        });
    }
</script>