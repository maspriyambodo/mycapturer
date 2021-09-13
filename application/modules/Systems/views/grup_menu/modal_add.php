<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_addLabel">Add new group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_add" action="<?php echo base_url('Systems/Menu_group/Save/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_grup">Group Name:</label>
                                <div class="input-group">
                                    <input id="nama_grup" type="text" name="nama_grup" class="form-control" autocomplete="off" required="" onchange="Check_nama(this.value)"/>
                                    <div id="check_nama" class="input-group-append"></div>
                                </div>
                                <input id="nama_stat" type="hidden" name="nama_stat" value=""/>
                                <div id="nama_msg"></div>
                            </div>
                            <div class="form-group">
                                <label for="order_no">Order</label>
                                <select id="order_no" name="order_no" class="form-select custom-select" required="" style="clear: both;width:100%;">
                                    <?php
                                    foreach ($group_dir as $group_dir) {
                                        $order_no = Enkrip($group_dir->order_no);
                                        echo '<option value="' . $order_no . '">After ' . $group_dir->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="des_grup">Group Description:</label>
                                <textarea id="des_grup" class="form-control" name="des_grup" required="" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" onclick="Save()"><i class="far fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#order_no').select2();
    function Check_nama(val) {
        $.ajax({
            url: "<?php echo base_url('Systems/Menu_group/Check_nama?nama='); ?>" + val,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#check_nama').empty();
                $('#nama_msg').empty();
                if (data.status) {
                    $('input[name="nama_stat"]').val(0);
                    $('#check_nama').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-times text-danger"></i>'
                            + '</span>'
                            );
                    $('#nama_msg').append('<small class="text-danger">' + data.msg + '</small>');
                } else {
                    $('input[name="nama_stat"]').val(1);
                    $('#check_nama').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-user-check text-success"></i>'
                            + '</span>'
                            );
                    $('#nama_msg').append('<small class="text-success">' + data.msg + '</small>');
                }
            }, error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Save() {
        var a, b, c;
        a = $('input[name="nama_grup"]').val();
        b = $('input[name="nama_stat"]').val();
        c = $('textarea[name="des_grup"]').val();
        if (!a | !b) {
            toastr.warning('please fill group name!');
        } else if (b == 0) {
            toastr.warning('please use other group name!');
        } else if (!c) {
            toastr.warning('please fill description group name!');
        } else if (c.length < 20) {
            toastr.warning('please provide a complete description!');
        } else {
            $("#form_add").submit();
        }
    }
</script>