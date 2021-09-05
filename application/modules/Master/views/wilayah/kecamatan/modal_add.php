<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_addLabel">Add new kecamatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_add" action="<?php echo site_url('Master/Wilayah/Kecamatan/Add/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kabtxt">Kabupaten</label>
                                <br>
                                <select id="kabtxt" name="kabtxt" class="form-control custom-select" required="" style="width: 100%;">
                                    <option value="">Search Kabupaten</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="a_id">ID Kecamatan:</label>
                                <div class="input-group">
                                    <input id="a_id" name="a_id" type="text" class="form-control" max="10" autocomplete="off" required="" onkeypress="return isNumber(event)" onchange="Kecamatan_id(this.value)"/>
                                    <div id="check_id" class="input-group-append"></div>
                                </div>
                                <input id="code_stat" type="hidden" name="code_stat" value=""/>
                                <div id="code_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kectxt">Kecamatan:</label>
                                <input type="text" id="kectxt" name="kectxt" class="form-control" required="" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longtxt">Longtitude:</label>
                                <input id="longtxt" type="text" name="longtxt" class="form-control" required="" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtlat">Latitude:</label>
                                <input id="txtlat" type="text" name="txtlat" class="form-control" required="" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancel</button>
                    <button type="button" class="btn btn-success font-weight-bold" onclick="Save_add()"><i class="far fa-trash-alt"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#kabtxt').select2({
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
    function Kecamatan_id(val) {
        $('#check_id').empty();
        $('#code_msg').empty();
        $.ajax({
            url: "<?php echo base_url('Master/Wilayah/Kecamatan/Get_id?id_kec='); ?>" + val,
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
        var a, b, c, d, e;
        a = $('input[name="a_id"]').val();
        b = $('input[name="code_stat"]').val();
        c = $('input[name="kectxt"]').val();
        d = $('input[name="longtxt"]').val();
        e = $('input[name="lattxt"]').val();
        if (!a) {
            toastr.warning('Please fill Kelurahan Code');
        } else if (b == 0) {
            toastr.warning('Please use another Kelurahan Code');
        } else if (!c) {
            toastr.warning('Please fill Kelurahan Name');
        } else {
            $('#form_add').submit();
        }
    }
</script>