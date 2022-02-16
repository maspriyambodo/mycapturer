<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_edit" action="<?php echo site_url('Systems/Parameter/update/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="param_id2">Parameter ID:</label>
                                <div class="input-group">
                                    <input type="text" id="param_id2" name="param_id2" class="form-control" autocomplete="off" required="" onchange="check_id2(this.value)" maxlength="32"/>
                                    <div id="param_append2" class="input-group-append"></div>
                                </div>
                                <input type="hidden" name="param_stat2"/>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="valtxt2">Value:</label>
                                <input type="text" id="valtxt2" name="valtxt2" class="form-control" autocomplete="off" required="" maxlength="32"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="grouptxt2">Group:</label>
                                <input type="text" name="grouptxt2" id="grouptxt2" class="form-control" autocomplete="off" required="" maxlength="32"/>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="desctxt2">Description:</label>
                                <textarea id="desctxt2" name="desctxt2" class="form-control" required="" maxlength="128"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="close_add2()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="button" class="btn btn-default font-weight-bold" onclick="save_btn2()"><i class="fas fa-save text-success"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Edit(id) {
        $.ajax({
            url: "<?php echo base_url('Systems/Parameter/get_detail?token='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.stat) {
                    document.getElementById('modal_editLabel').innerHTML = 'Edit: ' + data.id;
                    $('input[name="param_id2"]').val(data.id);
                    $('input[name="param_stat2"]').val(data.id);
                    $('input[name="valtxt2"]').val(data.param_value);
                    $('input[name="grouptxt2"]').val(data.param_group);
                    $('textarea[name="desctxt2"]').val(data.param_desc);
                    $('#modal_edit').modal({show: true, backdrop: 'static', keyboard: false});
                } else {
                    toastr.error('error while getting data!');
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function close_add2() {
        $('#modal_editLabel').empty();
        $('input[name="param_id2"]').val('');
        $('input[name="valtxt2"]').val('');
        $('input[name="grouptxt2"]').val('');
        $('textarea[name="desctxt2"]').val('');
        $('#param_append2').empty();
        $('input[name="param_stat2"]').val('');
    }
    function check_id2(val) {
        var old_param = $('input[name="param_stat2"]').val();
        $.ajax({
            url: "<?php echo base_url('Systems/Parameter/check_id?param_id='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#param_append2').empty();
                if (data.stat || val === old_param) {
                    $('#param_append2').append('<span class="input-group-text" title="name available to used"><i class="fas fa-check text-success"></i></span>');
                } else {
                    $('#param_append2').append('<span class="input-group-text" title="name cannot be used"><i class="fas fa-times text-danger"></i></span>');
                }
            },
            error: function () {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
                close_add2();
            }
        });
    }
    function save_btn2() {
        var a, b, c, d, e, result;
        a = $('input[name="param_id2"]').val();
        b = $('input[name="valtxt2"]').val();
        c = $('input[name="grouptxt2"]').val();
        d = $('textarea[name="desctxt2"]').val();
        e = $('input[name="param_stat2"]').val();
        if (a === '') {
            result = toastr.warning('please fill Parameter ID!');
            $('#param_id2').focus();
        } else if (b === '') {
            result = toastr.warning('please fill Parameter Value!');
            $('#valtxt2').focus();
        } else if (c === '') {
            result = toastr.warning('please fill Group!!');
            $('#grouptxt2').focus();
        } else if (d === '') {
            result = toastr.warning('please fill Description!');
            $('#desctxt2').focus();
        } else if (e === '') {
            result = toastr.warning('please use another Parameter ID!');
            $('#param_id2').focus();
        } else {
            result = $('#form_edit').submit();
        }
        return result;
    }
</script>