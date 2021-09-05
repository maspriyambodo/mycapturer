<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="card card-custom">
    <form action="<?php echo base_url('Compro/Gallery/Save/'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="titletxt">Title:</label>
                        <input type="text" class="form-control" id="titletxt" name="titletxt" required="" autocomplete="off" maxlength="100"/>
                        <input type="hidden" name="thumbnail_txt"/>
                        <input type="hidden" name="highres_txt"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipetxt">Type:</label>
                        <select id="tipetxt" name="tipetxt" class="form-control custom-select" required="" onchange="Tipetxt(this.value)">
                            <option value="">Choose type</option>
                            <option value="1">Image</option>
                            <option value="2">Video (Upload)</option>
                            <option value="3">Video (YouTube)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" id="tipe_form" style="display: none;"></div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="desctxt">Description:</label>
                        <textarea id="desctxt" class="form-control" name="desctxt" required=""></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <a href="<?php echo base_url('Compro/Gallery/index/'); ?>" class="btn btn-default"><i class="fas fa-undo-alt"></i> Cancel</a>
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
    </form>
</div>
<script>
    function Tipetxt(val) {
        if (!val) {
            $('#tipe_form').hide(1000);
            $('#tipe_form').empty();
            $('input[name="thumbnail_txt"]').val('');
            $('input[name="highres_txt"]').val('');
        } else if (val == 1) {
            $('#tipe_form').empty();
            $('input[name="thumbnail_txt"]').val('');
            $('input[name="highres_txt"]').val('');
            var tipe_form1 = $('#tipe_form').append(
                    '<div class="col-md-6"> <label for="thmbtxt">Thumbnail:</label> <div id="thmbtxt" class="dropzone"></div> </div> <div class="col-md-6"> <label for="hirestxt">High Resolution:</label> <div id="hirestxt" class="dropzone"></div> </div>'
                    );
            tipe_form1.show(1000);
            Dropzone.autoDiscover = false;
            var Thmbtxt = new Dropzone("#thmbtxt", {
                url: '<?php echo base_url('Compro/Gallery/Upload_image/thmbtxt'); ?>',
                paramName: "thmbtxt",
                maxFilesize: 1,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                success: function (data, response) {
                    $('input[name="thumbnail_txt"]').val(response.file_name);
                }
            });
            var Hirestxt = new Dropzone("#hirestxt", {
                url: '<?php echo base_url('Compro/Gallery/Upload_image/hirestxt'); ?>',
                paramName: "hirestxt",
                maxFilesize: 20,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                success: function (data, response) {
                    $('input[name="highres_txt"]').val(response.file_name);
                }
            });
        } else if (val == 2) {
            $('#tipe_form').empty();
            $('input[name="thumbnail_txt"]').val('');
            $('input[name="highres_txt"]').val('');
            var tipe_form2 = $('#tipe_form').append(
                    '<div class="col-md-6"> <label for="thmbvidtxt">Thumbnail:</label> <div id="thmbvidtxt" class="dropzone"></div> </div> <div class="col-md-6"> <label for="vidtxt">Video:</label> <div id="vidtxt" class="dropzone"></div> </div>'
                    );
            tipe_form2.slideDown(1000);
            Dropzone.autoDiscover = false;
            var Thmbvidtxt = new Dropzone("#thmbvidtxt", {
                url: '<?php echo base_url('Compro/Gallery/Upload_image/thmbvidtxt'); ?>',
                paramName: "thmbvidtxt",
                maxFilesize: 1,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                success: function (data, response) {
                    $('input[name="thumbnail_txt"]').val(response.file_name);
                }
            });
            var Vidtxt = new Dropzone("#vidtxt", {
                url: '<?php echo base_url('Compro/Gallery/Upload_image/hirestxt'); ?>',
                paramName: "hirestxt",
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: ".mp4,.mkv,.avi",
                success: function (data, response) {
                    $('input[name="highres_txt"]').val(response.file_name);
                }
            });
        } else if (val == 3) {
            $('#tipe_form').empty();
            $('input[name="thumbnail_txt"]').val('');
            $('input[name="highres_txt"]').val('');
            Dropzone.autoDiscover = false;
            var tipe_form3 = $('#tipe_form').append(
                    '<div class="col-md-6"> <label for="thmbyttxt">Video Thumbnail:</label> <div id="thmbyttxt" class="dropzone"></div> </div> <div class="col-md-6"> <label for="linktxt">Link Video:</label> <input type="url" id="linktxt" name="linktxt" class="form-control" required="" autocomplete="off"/> </div>'
                    );
            tipe_form3.slideDown(1000);
            var Thmbyttxt = new Dropzone("#thmbyttxt", {
                url: '<?php echo base_url('Compro/Gallery/Upload_image/thmbyttxt'); ?>',
                paramName: "thmbyttxt",
                maxFilesize: 1,
                uploadMultiple: false,
                maxFiles: 1,
                acceptedFiles: "image/jpeg,image/png,image/gif",
                success: function (data, response) {
                    $('input[name="thumbnail_txt"]').val(response.file_name);
                }
            });
        }
    }
</script>