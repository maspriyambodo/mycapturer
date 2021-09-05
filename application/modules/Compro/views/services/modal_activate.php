<div class="modal fade" id="modal_active" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_active" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_activeLabel">Activate Services</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_active()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Compro/Services/Activate/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="act_id"/>
                <div class="modal-body">
                    <p>activate the services, making the services accessible again</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_active()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-unlock"></i> Active</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Active(id) {
        $('input[name="act_id"]').val(id);
        $('#modal_active').modal({show: true, backdrop: 'static', keyboard: false});
    }
    function Close_active() {
        $('input[name="act_id"]').val('');
    }
</script>