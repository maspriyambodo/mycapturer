<div class="modal fade" id="modal_reset" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_reset" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_resetLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_reset()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Systems/Users/Reset/'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <input type="hidden" name="reset_id"/>
                    Are you sure want to reset password the user?
                    <div class="form-group" style="margin:10px 0px;">
                        <small>*password will be reset to <b>a</b></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_reset()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-key"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Reset_pwd(id) {
        $('input[name="reset_id"]').val(id);
        $('#modal_reset').modal({show: true, backdrop: 'static', keyboard: false});
    }
    function Close_reset() {
        $('input[name="reset_id"]').val('');
    }
</script>