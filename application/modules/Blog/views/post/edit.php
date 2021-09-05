<link href="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/plugins/autocomplete/skins/default.css" rel="stylesheet" type="text/css"/>
<script src="https://ckeditor.com/docs/vendors/4.14.0/ckeditor/ckeditor.js"></script>
<div class="card card-custom">
    <form id="post_form" action="<?php echo base_url('Blog/Post/Update/'); ?>" method="POST">
        <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
        <input type="hidden" name="id_post" value="<?php echo Enkrip($post['id']); ?>"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="post_title">Post Title:</label>
                        <input id="post_title" type="text" name="post_title" class="form-control form-control-lg" required="" autocomplete="off" value="<?php echo $post['post_title']; ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="post_content">Post Content:</label>
                        <textarea id="editor1" name="post_content"><?php echo $post['post_content']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stat_post">Status:</label>
                        <select id="stat_post" name="stat_post" required="" class="form-control custom-select">
                            <option value="">Select Status</option>
                            <?php
                            if ($post['post_status'] == 1) {
                                $publish = 'selected=""';
                                $draft = null;
                            } else {
                                $publish = null;
                                $draft = 'selected=""';
                            }
                            ?>
                            <option value="1"<?php echo $publish; ?>>Publish</option>
                            <option value="3"<?php echo $draft; ?>>Save as Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post_category">Post Categories:</label>
                        <select id="post_category" name="post_category" class="form-control custom-select" required="">
                            <option value="">Select Category</option>
                            <?php
                            foreach ($category as $category) {
                                $id_category = Enkrip($category->id);
                                if ($category->id == $post['id_category']) {
                                    $select_category = 'selected=""';
                                } else {
                                    $select_category = null;
                                }
                                echo '<option value="' . $id_category . '"' . $select_category . '>' . $category->category . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post_comment">Comment:</label>
                        <select id="post_comment" name="post_comment" class="form-control custom-select" required="">
                            <option value="">Select an option</option>
                            <?php
                            if ($post['comment_status'] == 1) {
                                $komen_open = 'selected=""';
                                $komen_close = null;
                            } else {
                                $komen_open = null;
                                $komen_close = 'selected=""';
                            }
                            ?>
                            <option value="1"<?php echo $komen_open; ?>>Open</option>
                            <option value="2"<?php echo $komen_close; ?>>Close</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="post_tags">tags:</label>
                        <input type="text" id="post_tags" name="post_tags" class="form-control" required="" autocomplete="off" value="<?php echo $post['post_tags']; ?>"/>
                        <small>separate with coma</small>
                    </div>
                    <?php
                    if (!empty($post['post_thumbnail'])) {
                        echo '<div class="form-group">'
                        . '<img src="' . base_url('assets/images/blog/thumb/' . $post['post_thumbnail']) . '" alt="' . $post['post_title'] . '" class="img-fluid"/>'
                        . '</div>';
                    } else {
                        null;
                    }
                    ?>
                    <div class="form-group">
                        <label for="post_tags">Thumbnail:</label>
                        <div id="thmbtxt" class="dropzone"></div>
                        <input type="hidden" name="thumbnail_txt" required=""/>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <div class="btn-group" role="group" aria-label="button form">
                    <button type="button" class="btn btn-light-danger font-weight-bold" onclick="Batal()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="button" class="btn btn-light-success font-weight-bold" onclick="Save()"><i class="fas fa-save"></i> Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    window.onload = function () {
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: false,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: "300",
            hideDuration: "2000",
            timeOut: false,
            extendedTimeOut: "2000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut"
        };
        CKEDITOR.replace('post_content', {
            filebrowserImageBrowseUrl: '<?= base_url('Elfinder_lib/manager/'); ?>'
        });
        $('.custom-select').select2();
        Dropzone.autoDiscover = false;
        var Thmbtxt = new Dropzone("#thmbtxt", {
            url: '<?php echo base_url('Blog/Post/Upload_image'); ?>',
            paramName: "thmbtxt",
            maxFilesize: 1,
            uploadMultiple: false,
            maxFiles: 1,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            success: function (data, response) {
                $('input[name="thumbnail_txt"]').val(response.file_name);
            }
        });
    };
    function Batal() {
        window.location.href = 'Blog/Post/index/';
    }
    function Save() {
        var a, b, c, d, e;
        a = $('input[name="post_title"]').val();
        b = $('select[name="stat_post"]').val();
        c = $('select[name="post_category"]').val();
        d = $('select[name="post_comment"]').val();
        e = $('input[name="post_tags"]').val();
        if (!a) {
            toastr.warning('Please fill Post Title');
        } else if (!b) {
            toastr.warning('Please select Post Status');
        } else if (!c) {
            toastr.warning('Please select Post Category');
        } else if (!d) {
            toastr.warning('Please select Post Comment');
        } else if (!e) {
            toastr.warning('Please fill Post tags');
        } else {

            $('#post_form').submit();
        }
    }
</script>