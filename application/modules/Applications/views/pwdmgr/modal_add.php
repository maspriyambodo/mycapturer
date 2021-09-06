<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_addLabel">Add data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_add()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Applications/Password_management/Add/'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <input type="hidden" name="e_id"/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_link">LINK:</label>
                                <input type="url" id="add_link" name="add_link" class="form-control" required="" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_uname">Username:</label>
                                <input type="text" id="add_uname" name="add_uname" class="form-control" required="" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_pwd">Password:</label>
                                <div class="input-group">
                                    <input type="password" id="add_pwd" name="add_pwd" class="form-control" required="" autocomplete="off">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-default" onclick="Showpwd_add()">
                                            <i class="fas fa-eye"></i>
                                        </button> 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="add_note">Note:</label>
                            <textarea id="add_note" name="add_note" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_add()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="fas fa-save"></i> Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Close_add() {
        if (type === "password") {
        } else {
            $("input[name=add_pwd]").attr('type', 'password');
            document.getElementsByClassName("fa-eye-slash").className = $(".fa-eye-slash").attr('class', 'fas fa-eye');
        }
    }
    function Showpwd_add() {
        var type = $("input[name=add_pwd]").attr('type');
        if (type === "password") {
            $("input[name=add_pwd]").attr('type', 'text');
            document.getElementsByClassName("fa-eye").className = $(".fa-eye").attr('class', 'fas fa-eye-slash');
        } else {
            $("input[name=add_pwd]").attr('type', 'password');
            document.getElementsByClassName("fa-eye-slash").className = $(".fa-eye-slash").attr('class', 'fas fa-eye');
        }
    }
</script>