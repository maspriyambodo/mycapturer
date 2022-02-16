<div class="modal fade" id="modal_edit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_edit()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_edit" action="<?php echo base_url('Master/Wilayah/Kecamatan/Update/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <input type="hidden" name="e_id"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_kectxt">Kabupaten:</label>
                                <br>
                                <select id="e_kectxt" name="e_kectxt" class="form-control custom-select" required="" style="width: 100%;"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_idkel">ID Kecamatan:</label>
                                <div class="input-group">
                                    <input id="e_idkel" name="e_idkel" type="text" class="form-control" max="10" autocomplete="off" required="" onkeypress="return isNumber(event)" readonly=""/>
                                    <div id="check_id" class="input-group-append"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_keltxt">Nama Kecamatan:</label>
                                <input type="text" id="e_keltxt" name="e_keltxt" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_longtxt">Longtitude:</label>
                                <input type="text" id="e_longtxt" name="e_longtxt" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="e_lattxt">Latitude:</label>
                                <input type="text" id="e_lattxt" name="e_lattxt" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Close_edit()">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#e_kectxt').select2({
        ajax: {
            url: '<?php echo base_url('Master/Wilayah/Kecamatan/Get_kab'); ?>',
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
        $('input[name="e_id"]').val("");
        $('input[name="e_idkel"]').val("");
        $('#e_kectxt').empty();
        $('input[name="e_keltxt"]').val("");
        $('input[name="e_longtxt"]').val("");
        $('input[name="e_lattxt"]').val("");
    }
    function Edit(val) {
        $.ajax({
            url: "<?php echo base_url('Master/Wilayah/Kecamatan/Detail?id='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.stat == true) {
                    document.getElementById('modal_editLabel').innerHTML = 'Edit Data ' + data.results.nama;
                    $('input[name="e_id"]').val(val);
                    var sel = document.getElementById("e_kectxt");
                    var opt = document.createElement("option");
                    opt.value = data.results.id_kabupaten;
                    opt.text = data.results.kabupaten;
                    sel.add(opt, sel.options);
                    $('input[name="e_idkel"]').val(data.results.id_kecamatan);
                    $('input[name="e_keltxt"]').val(data.results.nama);
                    $('input[name="e_longtxt"]').val(data.results.longitude);
                    $('input[name="e_lattxt"]').val(data.results.latitude);
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