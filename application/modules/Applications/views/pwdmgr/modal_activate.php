<div class="modal fade" id="modal_aktif" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_aktif" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Activated data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_aktif()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Applications/Password_management/Activated/'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <input type="hidden" name="act_id"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_aktif()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-power-off"></i> Activated</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Active_pwd(id) {
        $('input[name="act_id"]').val(id);
        $('#modal_aktif').modal({show: true, backdrop: 'static', keyboard: false});
    }
    function Close_aktif() {
        $('input[name="act_id"]').val("");
    }
</script>