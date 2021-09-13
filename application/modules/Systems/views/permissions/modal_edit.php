<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_delete" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_edit()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Systems/Permissions/Role_update/'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                    <input type="hidden" name="id_grup_edit"/>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="gr_parent_add">Group Parent:</label>
                                <div class="clearfix"></div>
                                <select id="gr_parent_edit" name="gr_parent_edit" class="form-control custom-select" required="" style="width:100%;">
                                    <option value="">Choose Parent</option>
                                    <option value="0">Parent</option>
                                    <?php
                                    foreach ($data as $parent_group) {
                                        echo '<option value="' . $parent_group->id_grup . '">' . $parent_group->nama_grup . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="gr_name_edit">Group Name:</label>
                                <input id="gr_name_edit" type="text" name="gr_name_edit" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="gr_desc_edit">Group Description:</label>
                                <textarea id="gr_desc_edit" name="gr_desc_edit" class="form-control" required=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"onclick="Close_edit()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-success font-weight-bold"><i class="far fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>