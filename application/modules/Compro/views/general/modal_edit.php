<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel">Edit option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_edit()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Compro/General/Update/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="e_id"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_nametxt">Option Name:</label>
                                <input type="text" id="e_nametxt" name="e_nametxt" class="form-control" required="" autocomplete="off" readonly=""/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="e_valuetxt">Option Value:</label>
                                <textarea id="e_valuetxt" name="e_valuetxt" class="form-control" required=""></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="e_desctxt">Description:</label>
                                <textarea id="e_desctxt" name="e_desctxt" class="form-control" required=""></textarea>
                            </div>
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
    function Close_edit() {
        $('input[name="e_nametxt"]').val('');
        $('textarea[name="e_valuetxt"]').val('');
        $('textarea[name="e_desctxt"]').val('');
    }
    function Edit(id) {
        $.ajax({
            'url': "<?php echo base_url('Compro/General/Get_detail?token='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.stat) {
                    $('input[name="e_id"]').val(data.id);
                    $('input[name="e_nametxt"]').val(data.option_name);
                    $('textarea[name="e_valuetxt"]').val(data.option_value);
                    $('textarea[name="e_desctxt"]').val(data.description);
                } else {
                    toastr.warning(data.msg);
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
</script>