<link href="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/plugins/autocomplete/skins/default.css" rel="stylesheet" type="text/css"/>
<script src="https://ckeditor.com/docs/vendors/4.14.0/ckeditor/ckeditor.js"></script>
<div class="card card-custom">
    <form id="post_form" action="<?php echo base_url('Compro/Services/save_page/'); ?>" method="POST">
        <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="post_title">Post Title:</label>
                        <?php
                        if (!empty($post_title)) {
                            echo '<select id="post_title" name="post_title" class="form-control custom-select" required="">';
                            echo '<option value="">Choose Services</option>';
                            foreach ($post_title as $post_title) {
                                echo '<option value="' . $post_title->id . '">' . $post_title->nama . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo '<a href="' . base_url('Compro/Services/List/') . '">add service</a>';
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="post_tags">Post Tags:</label>
                        <input type="text" id="post_tags" name="post_tags" class="form-control" required="" autocomplete="off" placeholder="tags1, tags2"/>
                        <small>separate with coma</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="post_content">Post Content:</label>
                <textarea id="editor1" name="post_content"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <div class="btn-group" role="group" aria-label="button form">
                    <button type="button" class="btn btn-light-danger font-weight-bold" onclick="Batal()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="button" class="btn btn-light-success font-weight-bold" onclick="Save()"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function Save() {
        var a, b, c, d, e;
        a = $('select[name="post_title"]').val();
        e = $('input[name="post_tags"]').val();
        if (!a) {
            toastr.warning('Please fill Post Title');
        } else if (!e) {
            toastr.warning('Please fill Post tags');
        } else {
            $('#post_form').submit();
        }
    }
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
            filebrowserImageBrowseUrl: '<?php echo base_url('Elfinder_lib/manager/'); ?>'
        });
        $('.custom-select').select2();
    };
    function Batal() {
        window.location.href = 'Compro/Services/Pages/';
    }
</script>