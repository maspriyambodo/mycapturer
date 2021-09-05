<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel">Edit Data Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_edit" action="<?php echo base_url('Master/Country/Update/'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="e_id"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code_country">Code Country:</label>
                                <div class="input-group">
                                    <input id="e_code_country" type="text" name="e_code_country" class="form-control text-uppercase" autocomplete="off" required="" maxlength="2" onchange="Check(this.value)"/>
                                    <div id="e_check_code" class="input-group-append"></div>
                                </div>
                                <input id="e_code_stat" type="hidden" name="e_code_stat" value="1"/>
                                <div id="e_code_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="e_name_country">Country:</label>
                                <input id="e_name_country" type="text" name="e_name_country" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Flags:</label>
                                <div class="clearfix" style="margin: 5px;"></div>
                                <div class="image-input image-input-outline" id="e_kt_image">
                                    <div class="image-input-wrapper"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change flag">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="e_flag_country" accept=".png, .jpg"/>
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
                    <button type="button" class="btn btn-success" onclick="Update()">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Edit(val) {
        var avatar4 = new KTImageInput('e_kt_image');
        $('input[name="e_code_country"]').val("");
        $('input[name="e_id"]').val("");
        $('input[name="e_name_country"]').val("");
        $('input[name="e_flag_country"]').val("");
        $('#kt_image_4').removeAttr('style');
        $('.image-input-wrapper').removeAttr('style');
        $.ajax({
            url: "<?php echo base_url('Master/Country/Edit?id='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('input[name="e_id"]').val(val);
                    $('input[name="e_code_country"]').val(data.exec.code_country);
                    $('input[name="e_name_country"]').val(data.exec.nama_country);
                    if (data.exec.flags) {
                        $('.image-input-wrapper').attr('style', 'background-image:url(<?php echo base_url('assets/images/systems/flags/'); ?>' + data.exec.flags + ');');
                    } else {
                        null;
                    }
                    $('#modal_edit').modal({show: true, backdrop: 'static', keyboard: false});
                } else {
                    toastr.warning('Error while getting data country');
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Check(val) {
        $('#e_check_code').empty();
        $('#e_code_msg').empty();
        $.ajax({
            url: "<?php echo base_url('Master/Country/Check?name='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('input[name="e_code_stat"]').val(0);
                    $('#e_check_code').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-times text-danger"></i>'
                            + '</span>'
                            );
                    $('#e_code_msg').append('<small class="text-danger">' + data.msg + '</small>');
                } else {
                    $('input[name="e_code_stat"]').val(1);
                    $('#e_check_code').append(
                            '<span class="input-group-text">'
                            + '<i class="far fa-check-circle text-success"></i>'
                            + '</span>'
                            );
                    $('#e_code_msg').append('<small class="text-success">' + data.msg + '</small>');
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Update() {
        var a, b, c;
        a = $('input[name="e_code_stat"]').val();
        b = $('input[name="e_code_country"]').val();
        c = $('input[name="e_name_country"]').val();
        if (a == 0) {
            toastr.warning('Please use another country code');
        } else if (!b) {
            toastr.warning('Please fill country code');
        } else if (!c) {
            toastr.warning('Please fill country name');
        } else {
            $('#form_edit').submit();
        }
    }
</script>