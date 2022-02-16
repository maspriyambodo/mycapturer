<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_addLabel">add new parameter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="close_add()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_add" action="<?php echo site_url('Systems/Parameter/add/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="param_id">Parameter ID:</label>
                                <div class="input-group">
                                    <input type="text" id="param_id" name="param_id" class="form-control" autocomplete="off" required="" onchange="check_id(this.value)" maxlength="32"/>
                                    <div id="param_append" class="input-group-append"></div>
                                </div>
                                <input type="hidden" name="param_stat"/>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="valtxt">Value:</label>
                                <input type="text" id="valtxt" name="valtxt" class="form-control" autocomplete="off" required="" maxlength="32"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold" for="grouptxt">Group:</label>
                                <input type="text" name="grouptxt" id="grouptxt" class="form-control" autocomplete="off" required="" maxlength="32"/>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold" for="desctxt">Description:</label>
                                <textarea id="desctxt" name="desctxt" class="form-control" required="" maxlength="128"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="close_add()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="button" class="btn btn-default font-weight-bold" onclick="save_btn()"><i class="fas fa-save text-success"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function close_add() {
        $('input[name="param_id"]').val('');
        $('input[name="valtxt"]').val('');
        $('input[name="grouptxt"]').val('');
        $('textarea[name="desctxt"]').val('');
        $('#param_append').empty();
        $('input[name="param_stat"]').val('');
    }
    function check_id(val) {
        $.ajax({
            url: "<?php echo base_url('Systems/Parameter/check_id?param_id='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#param_append').empty();
                if (data.stat) {
                    $('#param_append').append('<span class="input-group-text" title="name available to used"><i class="fas fa-check text-success"></i></span>');
                    $('input[name="param_stat"]').val(val);
                } else {
                    $('#param_append').append('<span class="input-group-text" title="name cannot be used"><i class="fas fa-times text-danger"></i></span>');
                    $('input[name="param_stat"]').val('');
                }
            },
            error: function () {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
                close_add();
            }
        });
    }
    function save_btn() {
        var a, b, c, d, e, result;
        a = $('input[name="param_id"]').val();
        b = $('input[name="valtxt"]').val();
        c = $('input[name="grouptxt"]').val();
        d = $('textarea[name="desctxt"]').val();
        e = $('input[name="param_stat"]').val();
        if (a === '') {
            result = toastr.warning('please fill Parameter ID!');
            $('#param_id').focus();
        } else if (b === '') {
            result = toastr.warning('please fill Parameter Value!');
            $('#valtxt').focus();
        } else if (c === '') {
            result = toastr.warning('please fill Group!!');
            $('#grouptxt').focus();
        } else if (d === '') {
            result = toastr.warning('please fill Description!');
            $('#desctxt').focus();
        } else if (e === '') {
            result = toastr.warning('please use another Parameter ID!');
            $('#param_id').focus();
        } else {
            result = $('#form_add').submit();
        }
        return result;
    }
</script>