<div class="modal fade" id="modal_order" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_order" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_orderLabel">Edit order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_order()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Systems/Menu_group/Change_order/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ro_from">From:</label>
                                <input type="hidden" name="from_id"/>
                                <input type="hidden" name="id_grup"/>
                                <input id="ro_from" type="text" name="ro_from" class="form-control" readonly=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ro_to">To:</label>
                                <select id="ro_to" name="ro_to" class="form-select custom-select" required=""></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_order()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-save"></i> Change</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Change_order(id) {
        $('#modal_order').modal({show: true, backdrop: 'static', keyboard: false});
        var group = $('input[name="nama' + id + '"]').val();
        var id_group = $('input[name="id_grup' + id + '"]').val();
        $('input[name="from_id"]').val(id);
        $('input[name="id_grup"]').val(id_group);
        $('input[name="ro_from"]').val(group);
        $.ajax({
            url: "<?php echo base_url('Systems/Menu_group/Get_id?id='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                var i;
                for (i = 0; i < data.length; i++) {
                    var sel = document.getElementById("ro_to");
                    var opt = document.createElement("option");
                    opt.value = data[i].id + ',' + data[i].order_no;
                    opt.text = data[i].nama;
                    sel.add(opt, sel.options[i]);
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Close_order() {
        $('#ro_to').empty();
        $('input[name="from_id"]').val('');
        $('input[name="id_grup"]').val('');
        $('input[name="ro_from"]').val('');
    }
</script>