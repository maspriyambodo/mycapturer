<div class="modal fade" id="modal_delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_deleteLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_delete()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Systems/Permissions/Delete/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="id_grup"/>
                <div class="modal-body">
                    deleting group causes system crash
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
    function Delete_group(id) {
        $.ajax({
            url: "<?php echo site_url('Systems/Permissions/Get_permission?id='); ?>" + id,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('input[name="id_grup"]').val(id);
                document.getElementById('modal_deleteLabel').innerHTML = 'Delete Group ' + data.value[0].grup_nama;
            },
            error: function () {
                document.getElementById('modal_deleteLabel').innerHTML = '';
                $('input[name="id_grup"]').val('');
                $('#modal_delete').modal('hide');
                toastr.warning('error while getting data!');
            }
        });
    }
    function Close_delete() {
        $('input[name="id_grup"]').val('');
        document.getElementById('modal_deleteLabel').innerHTML = '';
    }
</script>