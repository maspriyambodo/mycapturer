<div class="modal fade" id="modal_delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_deleteLabel">Delete Services Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_delete()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Compro/Pages/Delete/'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="d_id" readonly=""/>
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <p>data that has been deleted cannot be returned</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_delete()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold"><i class="far fa-trash-alt"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Close_delete(){
       $('input[name="d_id"]').val(''); 
    }
    function Delete(id) {
        $('input[name="d_id"]').val(id);
        $('#modal_delete').modal({show: true, backdrop: 'static', keyboard: false});
    }
</script>