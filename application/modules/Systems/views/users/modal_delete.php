<div class="modal fade" id="modal_delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_deleteBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_deleteLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_delmodal()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo base_url('Systems/Users/Delete/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="e_id"/>
                <div class="modal-body">
                    Are you sure want to delete users?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_delmodal()">Close</button>
                    <button type="submit" class="btn btn-danger font-weight-bold">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>