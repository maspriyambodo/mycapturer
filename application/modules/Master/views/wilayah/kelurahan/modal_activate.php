<div class="modal fade" id="modal_active" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_active" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_activeLabel">Active Kelurahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Master/Wilayah/Kelurahan/Activate/'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <input type="hidden" name="act_id"/>
                    <p>activate the kelurahan, making the kelurahan accessible again</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-unlock"></i> Active</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Active(val) {
        $('input[name="act_id"]').val(val);
        $('#modal_active').modal({show: true, backdrop: 'static', keyboard: false});
    }
</script>