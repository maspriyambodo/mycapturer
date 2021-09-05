<div class="card card-custom">
    <form action="<?php echo site_url('Systems/Users/Save'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
        <div class="card-body">
            <div class="image-input image-input-outline" id="kt_image_4" style="background-image:url('<?php echo site_url('assets/images/users/blank.png'); ?>');">
                <div class="image-input-wrapper"></div>
                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                    <i class="fa fa-pen icon-sm text-muted"></i>
                    <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg"/>
                    <input type="hidden" name="profile_avatar_remove"/>
                </label>
                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                    <i class="fas fa-times icon-xs text-muted"></i>
                </span>
                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                    <i class="fas fa-times icon-xs text-muted"></i>
                </span>
            </div>
            <div class="clearfix" style="margin:10px 0px;"></div>
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <label for="uname">Username:</label>
                        <div class="input-group">
                            <input id="uname" type="text" name="uname" class="form-control" autocomplete="off" required="" onchange="Check_uname()"/>
                            <div id="check_uname" class="input-group-append"></div>
                        </div>
                        <input id="uname_stat" type="hidden" name="uname_stat" value=""/>
                        <div id="uname_msg"></div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label for="uname">Roles:</label>
                        <select id="role_user" name="role_user" class="form-control" required="">
                            <option value="">Choose role</option>
                            <?php
                            foreach ($role as $a) {
                                echo '<option value="' . str_replace(['+', '/', '='], ['-', '_', '~'], $this->encryption->encrypt($a->id_grup)) . '">' . $a->nama_grup . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn-group">
                <button id="cancelbtn" type="button" class="btn btn-primary" onclick="Cancel()"><i class="fas fa-undo-alt"></i> Cancel</button>
                <button id="savebtn" type="button" class="btn btn-success" onclick="Save()"><i class="far fa-save"></i> Save</button>
            </div>
        </div>
        <div class="modal fade" id="modal_save" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_saveBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure want to save new users?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<input type="hidden" name="err_msg" value="<?php echo $this->session->flashdata('err_msg'); ?>"/>
<input type="hidden" name="succ_msg" value="<?php echo $this->session->flashdata('succ_msg'); ?>"/>
<?php
unset($_SESSION['err_msg']);
unset($_SESSION['succ_msg']);
?>
<script>
    window.onload = function () {
        var avatar4 = new KTImageInput('kt_image_4');
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
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
        var a, b;
        a = $('input[name="err_msg"]').val();
        b = $('input[name="succ_msg"]').val();
        if (a !== "") {
            toastr.error(a);
        } else if (b !== "") {
            toastr.success(b);
        }
    };
    function Cancel() {
        window.location.href = '<?php echo base_url('Systems/Users/index/'); ?>';
    }
    function Check_uname() {
        var uname = $('input[name="uname"]').val();
        $.ajax({
            url: "<?php echo site_url('Systems/Users/Check_uname?nama='); ?>" + uname,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#check_uname').empty();
                $('#uname_msg').empty();
                if (data.status) {
                    $('input[name="uname_stat"]').val(0);
                    $('#check_uname').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-times text-danger"></i>'
                            + '</span>'
                            );
                    $('#uname_msg').append('<small class="text-danger">' + data.msg + '</small>');
                } else {
                    $('input[name="uname_stat"]').val(1);
                    $('#check_uname').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-user-check text-success"></i>'
                            + '</span>'
                            );
                    $('#uname_msg').append('<small class="text-success">' + data.msg + '</small>');
                }
            },
            error: function () {
                toastr.warning('error while check username');
            }
        });
    }
    function Save() {
        var a, b, c;
        a = $('input[name="uname_stat"]').val();
        b = $('select[name="role_user"]').val();
        c = $('input[name="uname"]').val();
        if (!c) {
            toastr.warning('please fill username!');
        } else if (!b) {
            toastr.warning('please choose role user!');
        } else if (a == 0) {
            toastr.warning('please use other username!');
        } else {
            $('#modal_save').modal({show: true, backdrop: 'static', keyboard: false});
        }
    }
</script>