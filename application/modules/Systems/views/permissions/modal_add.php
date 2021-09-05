<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_addBackdrop" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo base_url('Systems/Permissions/Save/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="gr_parent_add">Group Parent:</label>
                                <div class="clearfix"></div>
                                <select id="gr_parent_add" name="gr_parent_add" class="form-control custom-select" required="" style="width:100%;">
                                    <option value="">Choose Parent</option>
                                    <option value="0">Parent</option>
                                    <?php
                                    foreach ($data as $parent_group) {
                                        echo '<option value="' . str_replace(['+', '/', '='], ['-', '_', '~'], $this->encryption->encrypt($parent_group->id_grup)) . '">' . $parent_group->nama_grup . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="gr_name_add">Group Name:</label>
                                <input id="gr_name_add" type="text" name="gr_name_add" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="gr_des_add">Group Description:</label>
                                <textarea id="gr_des_add" name="gr_des_add" class="form-control" rows="5" required=""></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default font-weight-bold" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><i class="far fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>