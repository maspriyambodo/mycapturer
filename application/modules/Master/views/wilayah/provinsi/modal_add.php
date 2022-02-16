<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Provinsi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="Close_add()">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form id="form_add" action="<?php echo base_url('Master/Wilayah/Provinsi/Save/'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prov_id">Provinsi ID:</label>
                                <div class="input-group">
                                    <input id="prov_id" type="text" name="prov_id" type="text" class="form-control" required="" autocomplete="off" onchange="Prov_id(this.value)" maxlength="2" onkeypress="return isNumber(event)"/>
                                    <div id="check_id" class="input-group-append"></div>
                                </div>
                                <input id="code_stat" type="hidden" name="code_stat" value=""/>
                                <div id="code_msg"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_prov">Provinsi:</label>
                                <input id="nama_prov" name="nama_prov" type="text" class="form-control" autocomplete="off" required=""/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtlong">Longtitude:</label>
                                <input id="txtlong" name="txtlong" type="text" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="txtlat">Latitude:</label>
                                <input id="txtlat" name="txtlat" type="text" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="Save()">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="Close_add()">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Close_add() {
        $('#check_id').empty();
        $('#code_msg').empty();
        $('input[name="code_stat"]').val("");
        $('input[name="prov_id"]').val("");
    }
    function Prov_id(val) {
        $('#check_id').empty();
        $('#code_msg').empty();
        $.ajax({
            url: "<?php echo base_url('Master/Wilayah/Provinsi/Get_id?id='); ?>" + val,
            type: 'GET',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.total > 0) {
                    $('input[name="code_stat"]').val(0);
                    $('#check_id').append(
                            '<span class="input-group-text">'
                            + '<i class="fas fa-times text-danger"></i>'
                            + '</span>'
                            );
                    $('#code_msg').append('<small class="text-danger">ID provinsi already exist!</small>');
                } else {
                    $('input[name="code_stat"]').val(0);
                    $('#check_id').append(
                            '<span class="input-group-text">'
                            + '<i class="far fa-check-circle text-success"></i>'
                            + '</span>'
                            );
                    $('#code_msg').append('<small class="text-success">ID provinsi available to use</small>');
                }
            },
            error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
    function Save() {

    }
</script>