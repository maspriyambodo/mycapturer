<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_edit()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo site_url('Blog/Categories/Update/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="e_id"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="e_category">Category:</label>
                            <input id="e_category" type="text" name="e_category" class="form-control" autocomplete="off" required=""/>
                        </div>
                        <div class="col-md-6">
                            <label for="e_desc">Description:</label>
                            <textarea id="e_desc" name="e_desc" class="form-control" required=""></textarea>
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
            url: "<?php echo base_url('Blog/Categories/Get_category?id_category='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('input[name="e_id"]').val(id);
                    $('input[name="e_category"]').val(data.exec.category);
                    $('textarea[name="e_desc"]').val(data.exec.descriptions);
                    $('#modal_edit').modal({show: true, backdrop: 'static', keyboard: false});
                } else {
                    toastr.warning(data.msg);
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Close_edit() {
        $('input[name="e_id"]').val("");
        $('input[name="e_category"]').val("");
        $('textarea[name="e_desc"]').val("");
    }
</script>