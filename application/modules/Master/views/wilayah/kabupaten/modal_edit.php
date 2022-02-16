<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_edit()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="edit_form" action="<?php echo site_url('Master/Wilayah/Kabupaten/Update/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="e_id"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_prov">Provinsi:</label>
                                <div class="clearfix"></div>
                                <select id="edit_prov" name="edit_prov" required="" class="form-control custom-select" style="width: 100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_idkab">Kabupaten ID:</label>
                                <div class="input-group">
                                    <input id="edit_idkab" type="text" name="edit_idkab" class="form-control" autocomplete="off" required="" onkeypress="return isNumber(event)" readonly=""/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_namakab">Kabupaten Name:</label>
                                <input type="text" id="edit_namakab" name="edit_namakab" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="edit_longt">Longtitude</label>
                            <input type="text" id="edit_longt" name="edit_longt" class="form-control" autocomplete="off" required=""/>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_lat">Latitude</label>
                            <input type="text" id="edit_lat" name="edit_lat" class="form-control" autocomplete="off" required=""/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_edit()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="submit" class="btn btn-light-success font-weight-bold"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#edit_prov').select2({
        ajax: {
            url: '<?php echo base_url('Master/Wilayah/Kabupaten/Get_prov'); ?>',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
    function Close_edit() {
        $('#edit_prov').empty();
        $('input[name="edit_idkab"]').val('');
        $('input[name="edit_namakab"]').val('');
        $('input[name="edit_longt"]').val('');
        $('input[name="edit_lat"]').val('');
    }
    function Edit(id) {
        $.ajax({
            url: "<?php echo base_url('Master/Wilayah/Kabupaten/Get_detail?id='); ?>" + id,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                document.getElementById('modal_editLabel').innerHTML = 'Edit Data ' + data.nama;
                $('input[name="e_id"]').val(id);
                var sel = document.getElementById("edit_prov");
                var opt = document.createElement("option");
                opt.value = data.id_provinsi;
                opt.text = data.provinsi;
                sel.add(opt, sel.options);
                $('input[name="edit_idkab"]').val(data.id_kabupaten);
                $('input[name="edit_namakab"]').val(data.nama);
                $('input[name="edit_longt"]').val(data.longitude);
                $('input[name="edit_lat"]').val(data.latitude);
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
</script>