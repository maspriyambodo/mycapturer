<div class="modal fade" id="modal_access" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_accessBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Group Access <b id="role_user"></b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_modal()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Systems/Permissions/Save_access/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="role_id"/>
                <div class="modal-body">
                    <div class="table-responsive" style="height: 400px;">
                        <table id="tbl_access" class="table table-bordered table-hover table-striped dataTable no-footer" role="grid">
                            <thead class="text-center text-uppercase">
                                <tr role="row">
                                    <th>MENU</th>
                                    <th>GROUP</th>
                                    <th>VIEW</th>
                                    <th>CREATE</th>
                                    <th>READ</th>
                                    <th>UPDATE</th>
                                    <th>DELETE</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_modal()">Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold" onclick="Save()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>