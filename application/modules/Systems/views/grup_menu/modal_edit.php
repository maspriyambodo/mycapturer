<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel">Edit group menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_edit()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_edit" action="<?php echo base_url('Systems/Menu_group/Update/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input id="e_id" type="hidden" name="e_id"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_nama_grup">Group Name:</label>
                                <div class="input-group">
                                    <input id="e_nama_grup" type="text" name="e_nama_grup" class="form-control" autocomplete="off" required="" onchange="Check(this.value)"/>
                                    <div id="e_check_nama" class="input-group-append"></div>
                                </div>
                                <input id="e_nama_stat" type="hidden" name="e_nama_stat" value="1"/>
                                <div id="e_nama_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_des_grup">Group Description:</label>
                                <textarea id="e_des_grup" class="form-control" name="e_des_grup" required="" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_edit()"><i class="far fa-times-circle"></i> Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" onclick="Update()"><i class="far fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Close_edit() {
        document.getElementById('modal_editLabel').innerHTML = '';
        $('input[name="e_nama_grup"]').val('');
        $('textarea[name="e_des_grup"]').val('');
    }
    function Edit(val) {
        $('#modal_edit').modal({show: true, backdrop: 'static', keyboard: false});
        $('input[name="e_nama_grup"]').val("");
        $('input[name="e_id"]').val("");
        $.ajax({
            url: "<?php echo base_url('Systems/Menu_group/Edit?id='); ?>" + val,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                document.getElementById('modal_editLabel').innerHTML = 'Edit Group: <b>' + data.exec.nama_grup + '</b>';
                if (data.status) {
                    $('input[name="e_nama_grup"]').val(data.exec.nama_grup);
                    $('input[name="e_id"]').val(val);
                    $('textarea[name="e_des_grup"]').val(data.exec.description);
                } else {
                    toastr.warning(data.msg);
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }

    function Update() {
        var a, b, c;
        a = $('input[name="e_nama_grup"]').val();
        b = $('input[name="e_nama_stat"]').val();
        c = $('textarea[name="e_des_grup"]').val();
        if (!a | !b) {
            toastr.warning('please fill group name!');
        } else if (b == 0) {
            toastr.warning('please use other group name!');
        } else if (!c) {
            toastr.warning('please fill description group name!');
        } else if (c.length < 20) {
            toastr.warning('please provide a complete description!');
        } else {
            $("#form_edit").submit();
        }
    }
    function Check(val) {
        $.ajax({
            url: "<?php echo base_url('Systems/Menu_group/Check_nama?nama='); ?>" + val,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#e_check_nama').empty();
                $('#e_nama_msg').empty();
                if (data.status) {
                    $('input[name="e_nama_stat"]').val(0);
                    $('#e_check_nama').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-times text-danger"></i>'
                            + '</span>'
                            );
                    $('#e_nama_msg').append('<small class="text-danger">' + data.msg + '</small>');
                } else {
                    $('input[name="e_nama_stat"]').val(1);
                    $('#e_check_nama').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-user-check text-success"></i>'
                            + '</span>'
                            );
                    $('#e_nama_msg').append('<small class="text-success">' + data.msg + '</small>');
                }
            }, error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
</script>