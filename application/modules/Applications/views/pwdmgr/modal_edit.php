<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_edit()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Applications/Password_management/Update/'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <input type="hidden" name="e_id"/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_link">LINK:</label>
                                <input type="url" id="e_link" name="e_link" class="form-control" required="" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_uname">Username:</label>
                                <input type="text" id="e_uname" name="e_uname" class="form-control" required="" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_pwd">Password:</label>
                                <div class="input-group">
                                    <input type="password" id="e_pwd" name="e_pwd" class="form-control" required="" autocomplete="off">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-default" onclick="Showpwd()">
                                            <i class="fas fa-eye"></i>
                                        </button> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="e_note">Note:</label>
                            <textarea id="e_note" name="e_note" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_edit()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Edit(id) {
        $.ajax({
            url: "<?php echo base_url('Applications/Password_management/Edit?id='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data) {
                    $('input[name="e_id"]').val(id);
                    $('input[name="e_link"]').val(data.link);
                    $('input[name="e_uname"]').val(data.uname);
                    $('input[name="e_pwd"]').val(data.pwd);
                    $('textarea[name="e_note"]').val(data.note);
                    $('#modal_edit').modal({show: true, backdrop: 'static', keyboard: false});
                } else {
                    toastr.warning('Error while getting data!');
                }
            }, error: function () {
                toastr.danger('Error while getting data!');
            }
        });
    }
    function Showpwd() {
        var type = $("input[name=e_pwd]").attr('type');
        if (type === "password") {
            $("input[name=e_pwd]").attr('type', 'text');
            document.getElementsByClassName("fa-eye").className = $(".fa-eye").attr('class', 'fas fa-eye-slash');
        } else {
            $("input[name=e_pwd]").attr('type', 'password');
            document.getElementsByClassName("fa-eye-slash").className = $(".fa-eye-slash").attr('class', 'fas fa-eye');
        }
    }
    function Close_edit() {
        var type = $("input[name=e_pwd]").attr('type');
        if (type === "password") {
        } else {
            $("input[name=e_pwd]").attr('type', 'password');
            document.getElementsByClassName("fa-eye-slash").className = $(".fa-eye-slash").attr('class', 'fas fa-eye');
        }
        $('input[name="e_id"]').val("");
        $('input[name="e_link"]').val("");
        $('input[name="e_uname"]').val("");
        $('input[name="e_pwd"]').val("");
        $('textarea[name="e_note"]').val("");
    }
</script>