<?php if ($privilege['update']) { ?>
    <div class="card card-custom">
        <form action="<?php echo base_url('Systems/Update/'); ?>" method="post">
            <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="favico">Fav Icon:</label>
                            <div class="clearfix"></div>
                            <img id="favico" src="<?php echo base_url('assets/images/systems/' . $this->bodo->Sys('favico')); ?>" style="max-width:35px;"/>
                            <div class="clearfix" style="margin:5px 0px;"></div>
                            <button type="button" id="edit_fav" class="btn btn-icon btn-default btn-xs" title="Change Favicon" onclick="Edit_fav()"><i class="far fa-edit"></i></button>
                            <div id="e_favicon"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="logo_company">Logo Company:</label>
                            <div class="clearfix"></div>
                            <img id="logo_company" src="<?php echo base_url('assets/images/systems/' . $this->bodo->Sys('logo')); ?>" style="max-width:250px;"/>
                            <div class="clearfix" style="margin:5px 0px;"></div>
                            <button type="button" id="edit_logo" class="btn btn-icon btn-default btn-xs" title="Change Logo Company" onclick="Edit_logo()"><i class="far fa-edit"></i></button>
                            <div id="e_logo"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="comp_name">Company Name:</label>
                            <input id="comp_name" type="text" name="comp_name" autocomplete="off" class="form-control" value="<?php echo $this->bodo->Sys('company_name'); ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="app_year">App Year</label>
                            <input id="app_year" type="text" name="app_year" class="form-control" autocomplete="off" value="<?php echo $this->bodo->Sys('app_year'); ?>" onkeypress="return isNumber(event)"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="app_name">App Name:</label>
                            <input id="app_name" type="text" name="app_name" autocomplete="off" class="form-control" value="<?php echo $this->bodo->Sys('app_name'); ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="far fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <input type="hidden" name="err_msg" value="<?php echo $this->session->flashdata('err_msg'); ?>"/>
    <input type="hidden" name="succ_msg" value="<?php echo $this->session->flashdata('succ_msg'); ?>"/>
    <?php
    unset($_SESSION['err_msg']);
    unset($_SESSION['succ_msg']);
    ?>
    <script>
        window.onload = function () {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                positionClass: "toast-top-right",
                preventDuplicates: true,
                onclick: null,
                showDuration: "300",
                hideDuration: "2000",
                timeOut: false,
                extendedTimeOut: "2000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
            var a, b;
            a = $('input[name="err_msg"]').val();
            b = $('input[name="succ_msg"]').val();
            if (a !== "") {
                toastr.error(a);
            } else if (b !== "") {
                toastr.success(b);
            }
        };
        function Edit_fav() {
            $('#favico').removeAttr('src');
            $('#edit_fav').hide('slow');
            $('#e_favicon').append(
                    '<input id="e_favico" type="file" name="e_favico" class="form-control" onchange="V_fav()"/>'
                    + '<div class="clearfix" style="margin:5px 0px;"></div>'
                    + '<button type="button" class="btn btn-icon btn-danger btn-xs" title="Cancel" onclick="C_fav()"><i class="fas fa-times-circle"></i></button>'
                    + '<button type="button" class="btn btn-icon btn-success btn-xs" title="Save" style="margin:0px 5px;" onclick="S_fav()"><i class="fas fa-save"></i></button>'
                    );
        }
        function V_fav() {
            var a = $('#e_favico')[0].files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#favico').attr('src', e.target.result);
            };
            reader.readAsDataURL(a);
        }
        function C_fav() {
            $('#favico').attr('src', '<?php echo base_url('assets/images/systems/' . $this->bodo->Sys('favico')); ?>');
            $('#edit_fav').show('slow');
            $('#e_favicon').empty();
        }
        function S_fav() {
            var fav = $('input[name="e_favico"]').val();
            if (fav) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "After replacing, everything will change",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "<i class='fas fa-save'></i> Yes",
                    showCancelButton: true,
                    cancelButtonText: "<i class='fas fa-window-close'></i> No",
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    }
                }).then(function (result) {
                    if (result.value) {
                        var a, b, c;
                        a = new FormData();
                        b = $('#e_favico')[0].files[0];
                        c = "<?php echo $csrf['hash']; ?>";
                        a.append('favico', b);
                        a.append('<?php echo $csrf['name']; ?>', c);
                        var url = '<?php echo base_url('Systems/Favico/'); ?>';
                        $.ajax({
                            url: url,
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            enctype: "multipart/form-data",
                            data: a,
                            success: function (data) {
                                console.log(data);
                                if (data.status) {
                                    Swal.fire({
                                        title: "Success",
                                        text: data.msg,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        showCancelButton: false,
                                        allowOutsideClick: false,
                                        customClass: {
                                            confirmButton: "btn btn-success"
                                        }
                                    }).then(function () {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Error", data.msg, "error");
                                }
                            },
                            error: function (data) {
                                Swal.fire("Error " + data.status, data.statusText, "error");
                                C_fav();
                            }
                        });
                    } else {

                    }
                });
            } else {
                toastr.warning('please choose file!');
            }
        }
        function Edit_logo() {
            $('#logo_company').removeAttr('src');
            $('#edit_logo').hide('slow');
            $('#e_logo').append(
                    '<input id="e_logocomp" type="file" name="e_logocomp" class="form-control" onchange="V_logo()"/>'
                    + '<div class="clearfix" style="margin:5px 0px;"></div>'
                    + '<button type="button" class="btn btn-icon btn-danger btn-xs" title="Cancel" onclick="C_logo()"><i class="fas fa-times-circle"></i></button>'
                    + '<button type="button" class="btn btn-icon btn-success btn-xs" title="Save" style="margin:0px 5px;" onclick="S_logo()"><i class="fas fa-save"></i></button>'
                    );
        }
        function V_logo() {
            var a = $('#e_logocomp')[0].files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#logo_company').attr('src', e.target.result);
            };
            reader.readAsDataURL(a);
        }
        function C_logo() {
            $('#logo_company').attr('src', '<?php echo base_url('assets/images/systems/' . $this->bodo->Sys('logo')); ?>');
            $('#edit_logo').show('slow');
            $('#e_logo').empty();
        }
        function S_logo() {
            var fav = $('input[name="e_logocomp"]').val();
            if (fav) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "After replacing, everything will change",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "<i class='fas fa-save'></i> Yes",
                    showCancelButton: true,
                    cancelButtonText: "<i class='fas fa-window-close'></i> No",
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: "btn btn-success",
                        cancelButton: "btn btn-danger"
                    }
                }).then(function (result) {
                    if (result.value) {
                        var a, b, c;
                        a = new FormData();
                        b = $('#e_logocomp')[0].files[0];
                        c = "<?php echo $csrf['hash']; ?>";
                        a.append('logo_comp', b);
                        a.append('<?php echo $csrf['name']; ?>', c);
                        var url = '<?php echo base_url('Systems/Logo/'); ?>';
                        $.ajax({
                            url: url,
                            type: 'POST',
                            cache: false,
                            contentType: false,
                            processData: false,
                            enctype: "multipart/form-data",
                            data: a,
                            success: function (data) {
                                if (data.status) {
                                    Swal.fire({
                                        title: "Success",
                                        text: data.msg,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "OK",
                                        showCancelButton: false,
                                        allowOutsideClick: false,
                                        customClass: {
                                            confirmButton: "btn btn-success"
                                        }
                                    }).then(function () {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire("Error", data.msg, "error");
                                }
                            },
                            error: function (data) {
                                Swal.fire("Error " + data.status, data.statusText, "error");
                                C_logo();
                            }
                        });
                    } else {

                    }
                });
            } else {
                toastr.warning('please choose file!');
            }
        }
        function isNumber(b) {
            b = (b) ? b : window.event;
            var a = (b.which) ? b.which : b.keyCode;
            if (a > 31 && (a < 48 || a > 57)) {
                return false;
            }
            return true;
        }
    </script>
    <?php
} else {
    null;
}
