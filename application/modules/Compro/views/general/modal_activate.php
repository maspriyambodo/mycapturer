<div class="modal fade" id="modal_active" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_activeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_activeLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_act()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Compro/General/Active/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="act_id"/>
                <div class="modal-body">
                    <p>data that has been deleted cannot be returned</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_act()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-default font-weight-bold"><i class="fas fa-lock-open text-success"></i> Active</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Active(id) {
        $('input[name="act_id"]').val(id);
        $.ajax({
            'url': "<?php echo base_url('Compro/General/Get_detail?token='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modal_activeLabel').html('Activing Setting <b>' + data.option_name + '</b>');
            }, error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Close_act() {
        $('input[name="act_id"]').val('');
        $('#modal_activeLabel').html('');
    }
</script>