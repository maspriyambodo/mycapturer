<div class="modal fade" id="modal_active" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_activeBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_activeLabel">Activate user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo base_url('Systems/Users/Active/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="act_id"/>
                <div class="modal-body">
                    Are you sure want to activate the user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success font-weight-bold">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>