<div class="card card-custom">
    <form action="<?php echo base_url('Systems/Update_pwd/'); ?>" method="post">
        <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
        <div class="card-body">
            <div class="row">
                <div class="col-md">
                    <div class="form-group">
                        <label for="old_pwd">Old Password:</label>
                        <div class="input-group">
                            <input id="old_pwd" name="old_pwd" type="password" class="form-control" required="" autocomplete="off" onchange="Old_pwd(this.value)"/>
                            <div id="check_pwd" class="input-group-append"></div>
                        </div>
                        <input id="pwd_stat" type="hidden" name="pwd_stat" value="0"/>
                        <div id="pwd_msg"></div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label for="new_pwd">New Password:</label>
                        <input id="new_pwd" type="password" name="new_pwd" class="form-control" required="" autocomplete="off"/>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-group">
                        <label for="cnf_pwd">Confirm Password:</label>
                        <input id="cnf_pwd" type="password" name="cnf_pwd" class="form-control" required="" autocomplete="off"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="text-right">
                <div class="form-group">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="Save()">Change</button>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_save" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_saveBackdrop" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure want change password?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Update</button>
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
        var a, b;
        a = $('input[name="err_msg"]').val();
        b = $('input[name="succ_msg"]').val();
        if (a !== "") {
            toastr.error(a);
        } else if (b !== "") {
            toastr.success(b);
        }
    };
    function Old_pwd(val) {
        $('#check_pwd').empty();
        $('#pwd_msg').empty();
        $.ajax({
            url: "<?php echo base_url('Systems/Old_pwd/'); ?>" + val,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('input[name="pwd_stat"]').val(1);
                    $('#check_pwd').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-lock-open text-success"></i>'
                            + '</span>'
                            );
                    $('#pwd_msg').append('<small class="text-success">' + data.msg + '</small>');
                } else {
                    $('input[name="pwd_stat"]').val(0);
                    $('#check_pwd').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-lock text-danger"></i>'
                            + '</span>'
                            );
                    $('#pwd_msg').append('<small class="text-danger">' + data.msg + '</small>');
                }
            },
            error: function () {
                toastr.warning('error while checking your password!');
            }
        });
    }
    function Save() {
        var a, b, c;
        a = $('input[name=pwd_stat]').val();
        b = $('input[name=new_pwd]').val();
        c = $('input[name=cnf_pwd]').val();
        if (a == 0) {
            toastr.warning('sorry, your old password was incorrect');
        } else if (c != b) {
            toastr.warning('sorry, your new password not match');
        } else {
            $('#modal_save').modal({show: true, backdrop: 'static', keyboard: false});
        }
    }
</script>