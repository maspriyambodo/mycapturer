<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel">Edit Data Provinsi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_edit" action="<?php echo base_url('Master/Wilayah/Provinsi/Update/'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="e_id"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prov_id">Provinsi ID:</label>
                                <input id="prov_id" name="prov_id" type="text" class="form-control" disabled=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_nama_prov">Provinsi:</label>
                                <input id="e_nama_prov" name="e_nama_prov" type="text" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_txtlong">Longtitude</label>
                                <input id="e_txtlong" name="e_txtlong" type="text" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_txtlat">Latitude</label>
                                <input id="e_txtlat" name="e_txtlat" type="text" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Update()">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Edit(val) {
        $('input[name="e_id"]').val("");
        $.ajax({
            url: "<?php echo base_url('Master/Wilayah/Provinsi/Get_?id='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status) {
                    $('input[name="e_id"]').val(val);
                    $('input[name="e_prov_id"]').val(data.exec.id_provinsi);
                    $('input[name="e_nama_prov"]').val(data.exec.nama_prov);
                    $('input[name="e_txtlong"]').val(data.exec.ltd);
                    $('input[name="e_txtlat"]').val(data.exec.lat);
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
    function Update() {
        var a, b, c;
        a = $('input[name="e_txtlong"]').val();
        b = $('input[name="e_txtlat"]').val();
        c = $('input[name="e_nama_prov"]').val();
        if (!a) {
            toastr.warning('please fill longtitude');
        } else if (!b) {
            toastr.warning('please fill latitude');
        } else if (!c) {
            toastr.warning('please fill provinsi name');
        } else {
            $('#form_edit').submit();
        }
    }
</script>