<div class="modal fade" id="modal_delete" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_deleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_deleteLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_delete()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Systems/Parameter/delete/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="param_id3" required=""/>
                <input type="hidden" name="nama_param" required=""/>
                <div class="modal-body">
                    <div class="text-danger">deleting system parameter causes system crash!</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="close_delete()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-danger font-weight-bold"><i class="far fa-trash-alt"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Delete(id) {
        $.ajax({
            url: "<?php echo base_url('Systems/Parameter/get_detail?token='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.stat) {
                    document.getElementById('modal_deleteLabel').innerHTML = 'Delete: ' + data.id;
                    $('input[name="param_id3"]').val(id);
                    $('input[name="nama_param"]').val(data.id);
                    $('#modal_delete').modal({show: true, backdrop: 'static', keyboard: false});
                } else {
                    toastr.warning('error while getting data!');
                    $('input[name="param_id3"]').val('');
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function close_delete() {
        $('input[name="param_id3"]').val('');
    }
</script>