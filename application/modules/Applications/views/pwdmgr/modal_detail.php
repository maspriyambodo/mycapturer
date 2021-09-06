<div class="modal fade" id="modal_detail" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_detail" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_detail()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="v_link">LINK:</label>
                            <input type="url" id="v_link" name="v_link" class="form-control" disabled=""/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="v_uname">Username:</label>
                            <input type="text" id="v_uname" name="v_uname" class="form-control" disabled=""/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="v_pwd">Password:</label>
                            <div class="input-group">
                                <input type="text" id="v_pwd" name="v_pwd" class="form-control" readonly=""/>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-success" onclick="Copy_pwd()">copy</button> 
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="v_note">Note:</label>
                        <textarea id="v_note" name="v_note" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_detail()"><i class="far fa-times-circle"></i> Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
    function Detail_pwd(id) {
        $.ajax({
            url: "<?php echo base_url('Applications/Password_management/Edit?id='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data) {
                    $('input[name="v_link"]').val(data.link);
                    $('input[name="v_uname"]').val(data.uname);
                    $('input[name="v_pwd"]').val(data.pwd);
                    $('input[name="cp_pwd"]').val(data.pwd);
                    $('textarea[name="v_note"]').val(data.note);
                    $('#modal_detail').modal({show: true, backdrop: 'static', keyboard: false});
                } else {
                    toastr.warning('Error while getting data!');
                }
            }, error: function () {
                toastr.danger('Error while getting data!');
            }
        });
    }
    function Close_detail() {
        $('input[name="v_link"]').val("");
        $('input[name="v_uname"]').val("");
        $('input[name="v_pwd"]').val("");
        $('textarea[name="v_note"]').val("");
    }
    function Copy_pwd() {
        var cpo = document.getElementById('v_pwd');
        cpo.select();
        cpo.setSelectionRange(0, 99999);
        document.execCommand("copy");
        toastr.success('password copied !');
    }
</script>