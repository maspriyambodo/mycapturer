<div class="card card-custom">
    <form action="<?php echo base_url('Systems/Profile_save/'); ?>" method="post" enctype="multipart/form-data">
        <input name="provtxt" type="hidden" value="<?php echo Enkrip($data[0]->address_provinsi); ?>" readonly=""/>
        <input name="kabtxt" type="hidden" value="<?php echo $data[0]->address_kabupaten; ?>" readonly=""/>
        <input name="kectxt" type="hidden" value="<?php echo $data[0]->address_kecamatan; ?>" readonly=""/>
        <input name="keltxt" type="hidden" value="<?php echo $data[0]->address_kelurahan; ?>" readonly=""/>
        <div class="card-body">
            <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
            <div class="form-group row">
                <label class="col-form-label col-3 text-lg-right text-left">Avatar</label>
                <div class="col-9">
                    <div class="image-input image-input-outline" id="kt_image_4" style="background-image:url('<?php echo site_url('assets/images/users/' . $data[0]->pict); ?>');">
                        <div class="image-input-wrapper"></div>
                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                            <i class="fa fa-pen icon-sm text-muted"></i>
                            <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" value="<?php echo $data[0]->pict; ?>"/>
                            <input type="hidden" name="profile_avatar_remove"/>
                            <input type="hidden" name="old_ava" value="<?php echo $data[0]->pict; ?>"/>
                        </label>
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                            <i class="fas fa-times icon-xs text-muted"></i>
                        </span>
                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove avatar">
                            <i class="fas fa-times icon-xs text-muted"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">ID Number <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="KTP/SIM/PASSPORT"></i></label>
                <div class="col-md-6">
                    <input name="id_num" class="form-control form-control-lg" type="text" value="<?php echo $data[0]->id_number; ?>" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Fullname</label>
                <div class="col-md-6">
                    <input name="nama_lengkap" class="form-control form-control-lg" type="text" value="<?php echo $data[0]->nama_lengkap; ?>" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Username</label>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="hidden" name="old_uname" value="<?php echo $data[0]->uname; ?>"/>
                        <input name="uname" class="form-control form-control-lg" type="text" value="<?php echo $data[0]->uname; ?>" autocomplete="off" onchange="Check_uname(this.value)"/>
                        <div id="check_id" class="input-group-append"></div>
                    </div>
                    <input id="code_stat" type="hidden" name="code_stat" value=""/>
                    <div id="code_msg"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Email</label>
                <div class="col-md-6">
                    <input name="mail_user" class="form-control form-control-lg" type="email" value="<?php echo $data[0]->mail; ?>" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Phone</label>
                <div class="col-md-6">
                    <input name="tlepon" class="form-control form-control-lg" type="text" value="<?php echo $data[0]->telp; ?>" autocomplete="off" onkeypress="return isNumber(event)" maxlength="13"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Role</label>
                <div class="col-md-6">
                    <input name="roles_name" class="form-control form-control-lg form-control-solid" type="text" value="<?php echo $data[0]->name_role; ?>" disabled=""/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Sex</label>
                <div class="col-md-6">
                    <select name="gender" class="form-control custom-select" required="">
                        <?php
                        if ($data[0]->jenis_kelamin == 1) {
                            $male = ' selected=""';
                            $female = null;
                        } elseif ($data[0]->jenis_kelamin == 2) {
                            $male = null;
                            $female = ' selected=""';
                        } else {
                            $male = null;
                            $female = null;
                        }
                        ?>
                        <option value="">Choose option</option>
                        <option value="1"<?php echo $male; ?>> Male</option>
                        <option value="2"<?php echo $female; ?>> Female</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Born</label>
                <div class="col-md-6">
                    <input name="place_born" class="form-control form-control-lg" type="text" value="<?php echo $data[0]->lahir_1; ?>" autocomplete="off"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Date Birth</label>
                <div class="col-md-6">
                    <input name="date_birth" class="form-control form-control-lg datepicker" type="text" value="<?php echo $data[0]->lahir_2; ?>" autocomplete="off" style="width:100%;" onkeydown="return false;"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Provinsi</label>
                <div class="col-md-6">
                    <select name="provinsi" class="form-control custom-select" required="" onchange="Provinsi(this.value)">
                        <option value="">Choose Provinsi</option>
                        <?php
                        foreach ($prov as $provinsi) {
                            $id = Enkrip($provinsi->id_provinsi);
                            if ($this->bodo->Dec($id) == $data[0]->address_provinsi) {
                                $prov_selected = ' selected=""';
                            } else {
                                $prov_selected = null;
                            }
                            echo '<option value="' . $id . '"' . $prov_selected . '>' . $provinsi->nama . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Kabupaten</label>
                <div class="col-md-6">
                    <select id="kabupaten" name="kabupaten" class="form-control custom-select" required="" onchange="Kecamatan(this.value)"></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Kecamatan</label>
                <div class="col-md-6">
                    <select id="kecamatan" name="kecamatan" class="form-control custom-select" required="" onchange="Kelurahan(this.value)"></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Kelurahan</label>
                <div class="col-md-6">
                    <select id="kelurahan" name="kelurahan" class="form-control custom-select" required=""></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-md-3 text-lg-right text-left">Address</label>
                <div class="col-md-6">
                    <textarea name="alamat" class="form-control" required=""><?php echo $data[0]->address_1; ?></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-group text-right">
                <button type="button" class="btn btn-success" onclick="Save()">Save Changes</button>
                <button type="button" class="btn btn-default" onclick="Cancel()">Cancel</button>
            </div>
        </div>
        <!-- BATAS====================================================================BATAS====================================================================BATAS -->
        <div class="modal fade" id="modal_save" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Save Data</h4>
                    </div>
                    <div class="modal-body">
                        are sure you want to save?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No!</button>
                        <button type="submit" class="btn btn-info">Yes!</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- BATAS====================================================================BATAS====================================================================BATAS -->
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
        var avatar4 = new KTImageInput('kt_image_4');
        $('.custom-select').select2();
        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: true,
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
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
        var provtxt, kabtxt, kectxt, keltxt;
        provtxt = $('input[name="provtxt"]').val();
        kabtxt = $('input[name="kabtxt"]').val();
        kectxt = $('input[name="kectxt"]').val();
        keltxt = $('input[name="keltxt"]').val();
        Provinsi(provtxt);
    };
    function Cancel() {
        window.location.href = '<?php echo base_url('Setting%20Profile'); ?>';
    }

    function Provinsi(id) {
        $('#kabupaten').children('option').remove();
        $('#kecamatan').children('option').remove();
        $('#kelurahan').children('option').remove();
        $.ajax({
            url: "<?php echo base_url('Systems/Getkab?id_provinsi='); ?>" + id,
            type: 'get',
            dataType: 'json',
            cache: false,
            success: function (data) {
                var id_kab = $('input[name="kabtxt"]').val();
                var i;
                for (i = 0; i < data.length; i++) {
                    var sel = document.getElementById("kabupaten");
                    var opt = document.createElement("option");
                    opt.value = data[i].id_kabupaten;
                    opt.text = data[i].kabupaten;
                    sel.add(opt, sel.options[i]);
                    if (opt.value == id_kab) {
                        $('select option[value="' + id_kab + '"]').attr('selected', true);
                        Kecamatan(id_kab);
                    }
                }
            },
            error: function () {
                toastr.error("Error ketika mengambil data kabupaten");
            }
        });
    }
    function Kecamatan(id) {
        $('#kelurahan').children('option').remove();
        $.ajax({
            url: "<?php echo base_url('Systems/Getkec?id_kec='); ?>" + id,
            type: 'get',
            dataType: 'json',
            cache: false,
            success: function (data) {
                var id_kec = $('input[name="kectxt"]').val();
                var i;
                for (i = 0; i < data.length; i++) {
                    var sel = document.getElementById("kecamatan");
                    var opt = document.createElement("option");
                    opt.value = data[i].id_kecamatan;
                    opt.text = data[i].kecamatan;
                    sel.add(opt, sel.options[i]);
                    if (opt.value == id_kec) {
                        $('select option[value="' + id_kec + '"]').attr('selected', true);
                        Kelurahan(id_kec);
                    }
                }
            },
            error: function () {
                toastr.error("Error ketika mengambil data kecamatan");
            }
        });
    }
    function Kelurahan(id) {
    $('#kelurahan').children('option').remove();
        $.ajax({
            url: "<?php echo base_url('Systems/Getkel?id_kec='); ?>" + id,
            type: 'get',
            dataType: 'json',
            cache: false,
            success: function (data) {
                var id_kel = $('input[name="keltxt"]').val();
                var i;
                for (i = 0; i < data.length; i++) {
                    var sel = document.getElementById("kelurahan");
                    var opt = document.createElement("option");
                    opt.value = data[i].id_kelurahan;
                    opt.text = data[i].kelurahan;
                    sel.add(opt, sel.options[i]);
                    if (opt.value == id_kel) {
                        $('select option[value="' + id_kel + '"]').attr('selected', true);
                    }
                }
            },
            error: function () {
                toastr.error("Error ketika mengambil data kelurahan");
            }
        });
    }
    function isNumber(b) {
        b = (b) ? b : window.event;
        var a = (b.which) ? b.which : b.keyCode;
        if (a > 31 && (a < 48 || a > 57)) {
            return false;
        }
        return true;
    }
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }
    function Save() {
        var a, b, c, d, e, f, g, h, i, j, k, l, m, n;
        a = $('input[name="id_num"]').val();
        b = $('input[name="nama_lengkap"]').val();
        c = $('input[name="uname"]').val();
        d = $('input[name="mail_user"]').val();
        e = $('input[name="tlepon"]').val();
        f = $('select[name="gender"]').val();
        g = $('input[name="place_born"]').val();
        h = $('input[name="date_birth"]').val();
        i = $('select[name="provinsi"]').val();
        j = $('select[name="kabupaten"]').val();
        k = $('select[name="kelurahan"]').val();
        m = $('select[name="kecamatan"]').val();
        l = $('textarea[name="alamat"]').val();
        n = $('input[name="code_stat"]').val();
        if (!a | a.length <= 15) {
            toastr.warning('please fill valid ID Number');
        } else if (!b) {
            toastr.warning('please fill Fullname');
        } else if (!c) {
            toastr.warning('please fill username');
        } else if (!d | !validateEmail(d)) {
            toastr.warning('please fill email');
        } else if (!e | e.length <= 5) {
            toastr.warning('please fill phone number');
        } else if (!f) {
            toastr.warning('please choose your gender');
        } else if (!g) {
            toastr.warning('please fill place of birth');
        } else if (!h) {
            toastr.warning('please fill date of birth');
        } else if (!i) {
            toastr.warning('please select your provinsi');
        } else if (!j) {
            toastr.warning('please select your kabupaten');
        } else if (!k) {
            toastr.warning('please select your kelurahan');
        } else if (!l) {
            toastr.warning('please fill your address');
        } else if (!m) {
            toastr.warning('please select your kecamatan');
        } else if (n === 0) {
            toastr.warning('please use another username!');
        } else {
            $('#modal_save').modal({show: true, backdrop: 'static', keyboard: false});
        }
    }
    function Check_uname(val) {
        $('#check_id').empty();
        $('#code_msg').empty();
        var old_uname = $('input[name="old_uname"]').val();
        var uname = $('input[name="uname"]').val();
        $.ajax({
            url: "<?php echo base_url('Systems/Check_uname?val='); ?>" + val,
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
                } else if (uname === old_uname) {
                    $('input[name="code_stat"]').val(1);
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
</script>