<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_add" action="<?php echo base_url('Master/Country/Save/'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code_country">Code Country:</label>
                                <div class="input-group">
                                    <input id="code_country" type="text" name="code_country" class="form-control text-uppercase" autocomplete="off" required="" maxlength="2" onchange="Check_country(this.value)"/>
                                    <div id="check_code" class="input-group-append"></div>
                                </div>
                                <input id="code_stat" type="hidden" name="code_stat" value=""/>
                                <div id="code_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name_country">Country:</label>
                                <input id="name_country" type="text" name="name_country" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Flags:</label>
                                <div class="clearfix" style="margin: 5px;"></div>
                                <div class="image-input image-input-outline" id="kt_image_4">
                                    <div class="image-input-wrapper"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change flag">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="flag_country" accept=".png, .jpg"/>
                                        <input type="hidden" name="profile_avatar_remove"/>
                                    </label>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel flag">
                                        <i class="fas fa-times icon-xs text-muted"></i>
                                    </span>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove flag">
                                        <i class="fas fa-times icon-xs text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Save()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var avatar4 = new KTImageInput('kt_image_4');
    function Check_country(val) {
        $('#check_code').empty();
        $('#code_msg').empty();
        $.ajax({
            url: "<?php echo base_url('Master/Country/Check?name='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('input[name="code_stat"]').val(0);
                    $('#check_code').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-times text-danger"></i>'
                            + '</span>'
                            );
                    $('#code_msg').append('<small class="text-danger">' + data.msg + '</small>');
                } else {
                    $('input[name="code_stat"]').val(1);
                    $('#check_code').append(
                            '<span class="input-group-text">'
                            + '<i class="far fa-check-circle text-success"></i>'
                            + '</span>'
                            );
                    $('#code_msg').append('<small class="text-success">' + data.msg + '</small>');
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Save() {
        var a, b, c;
        a = $('input[name="code_stat"]').val();
        b = $('input[name="code_country"]').val();
        c = $('input[name="name_country"]').val();
        if (a == 0) {
            toastr.warning('Please use another country code');
        } else if (!b) {
            toastr.warning('Please fill country code');
        } else if (!c) {
            toastr.warning('Please fill country name');
        } else {
            $('#form_add').submit();
        }
    }
</script>