<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_addLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_addLabel">Add new Kabupaten</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_add()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="add_form" action="<?php echo site_url('Master/Wilayah/Kabupaten/Add/'); ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_prov">Provinsi:</label>
                                <div class="clearfix"></div>
                                <select id="add_prov" name="add_prov" required="" class="form-control custom-select" style="width:100%;">
                                    <option value="">Choose Provinsi</option>
                                    <?php
                                    foreach ($prov as $provinsi) {
                                        $id = Enkrip($provinsi->id_provinsi);
                                        echo '<option value="' . $id . '">' . $provinsi->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_idkab">Kabupaten ID:</label>
                                <div class="input-group">
                                    <input id="add_idkab" type="text" name="add_idkab" class="form-control" autocomplete="off" required="" onkeypress="return isNumber(event)" onchange="Kab_id(this.value)"/>
                                    <div id="check_id" class="input-group-append"></div>
                                </div>
                                <input id="code_stat" type="hidden" name="code_stat" value=""/>
                                <div id="code_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="add_namakab">Kabupaten Name:</label>
                                <input type="text" id="add_namakab" name="add_namakab" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="add_longt">Longtitude</label>
                            <input type="text" id="add_longt" name="add_longt" class="form-control" autocomplete="off" required=""/>
                        </div>
                        <div class="col-md-6">
                            <label for="add_lat">Latitude</label>
                            <input type="text" id="add_lat" name="add_lat" class="form-control" autocomplete="off" required=""/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal" onclick="Close_add()"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="button" class="btn btn-light-success font-weight-bold" onclick="Save_add()"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#add_prov').select2();
    function Close_add() {
        $('#check_id').empty();
        $('#code_msg').empty();
        $('input[name="code_stat"]').val("");
        $('input[name="add_idkab"]').val("");
    }
    function Kab_id(val) {
        $('#check_id').empty();
        $('#code_msg').empty();
        $.ajax({
            url: "<?php echo base_url('Master/Wilayah/Kabupaten/Get_id?id_kab='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.stat == true) {
                    $('input[name="code_stat"]').val(1);
                    $('#check_id').append(
                            '<span class="input-group-text">'
                            + '<i class="far fa-check-circle text-success"></i>'
                            + '</span>'
                            );
                    $('#code_msg').append('<small class="text-success">' + data.msg + '</small>');
                } else {
                    $('input[name="code_stat"]').val(0);
                    $('#check_id').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-times text-danger"></i>'
                            + '</span>'
                            );
                    $('#code_msg').append('<small class="text-danger">' + data.msg + '</small>');
                }
            },
            error: function () {
                toastr.danger('error while checking ID, please reload page!');
            }
        });
    }
    function Save_add() {
        var a, b, c;
        a = $('input[name="code_stat"]').val();
        b = $('input[name="add_namakab"]').val();
        c = $('select[name="add_prov"]').val();
        if (!a) {
            toastr.warning('please fill ID Kabupaten!');
        } else if (a == 0) {
            toastr.warning('please use another ID Kabupaten!');
        } else if (!b) {
            toastr.warning('please fill Kabupaten Name!');
        } else if (!c) {
            toastr.warning('please choose Provinsi Name!');
        } else {
            $('#add_form').submit();
        }
    }
</script>