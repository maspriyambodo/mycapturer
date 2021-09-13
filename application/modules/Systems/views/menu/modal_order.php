<div class="modal fade" id="modal_order" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_order" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_orderLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_order()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Systems/Menu/Change_order/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="menu_name">From</label>
                                <input type="hidden" name="old_group_id"/>
                                <input type="hidden" name="old_order_no"/>
                                <input type="hidden" name="old_menu_parent"/>
                                <input type="hidden" name="old_menu_id"/>
                                <input id="menu_name" type="text" name="menu_name" class="form-control" readonly=""/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center form-group">
                                <div class="clearfix" style="margin:35px 0px;">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="new_order">To</label>
                                <select id="new_order" name="new_order" class="form-select custom-select" required=""></select>
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
        var a, b, c, d;
        a = $('input[name="group_id' + id + '"]').val();
        b = $('input[name="order_old' + id + '"]').val();
        c = $('input[name="menu_parent' + id + '"]').val();
        d = $('#nama_menu' + id).text();
        $('input[name="menu_parent' + id + '"]').val();
        $('input[name="old_group_id"]').val(a);
        $('input[name="old_order_no"]').val(b);
        $('input[name="old_menu_parent"]').val(c);
        $('input[name="old_menu_id"]').val(id);
        $.ajax({
            url: "<?php echo base_url('Systems/Menu/Get_detail?id_menu='); ?>" + id + '&group_id=' + a + '&order_no=' + b + '&menu_parent=' + c,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#modal_order').modal({show: true, backdrop: 'static', keyboard: false});
                $('input[name="menu_name"]').val(d);
                document.getElementById('modal_orderLabel').innerHTML = 'Change Order: ' + d;
                var i;
                for (i = 0; i < data.length; i++) {
                    var sel = document.getElementById("new_order");
                    var opt = document.createElement("option");
                    opt.value = data[i].id + ',' + data[i].order_no;
                    opt.text = data[i].nama;
                    sel.add(opt, sel.options[i]);
                }
            }, error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Close_order() {
        $('input[name="menu_name"]').val('');
        document.getElementById('modal_orderLabel').innerHTML = '';
        $('#new_order').empty();
        $('input[name="old_group_id"]').val('');
        $('input[name="old_order_no"]').val('');
        $('input[name="old_menu_parent"]').val('');
        $('input[name="old_menu_id"]').val('');
    }
</script>