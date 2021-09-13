function Edit(id) {
    $.ajax({
        url: "<?php echo base_url('Systems/Permissions/Get_role?id='); ?>" + id,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.status) {
                document.getElementById('modal_editLabel').innerHTML = 'Edit Group ' + data.value.nama_grup;
                $('input[name="gr_name_edit"]').val(data.value.nama_grup);
                $('input[name="id_grup_edit"]').val(id);
                $('textarea[name="gr_desc_edit"]').val(data.value.des_grup);
                $('#gr_parent_edit').val(data.value.parent_id);
                $('#gr_parent_edit').select2().trigger('change');
                $('#modal_edit').modal({show: true, backdrop: 'static', keyboard: false});
            } else {
                Swal.fire("Error " + data.status, data.msg, "error");
            }
        }, error: function (data) {
            Swal.fire("Error " + data.status, data.statusText, "error");
        }
    });
}
function Get_access(val) {
    $('input[name="role_id"]').val(val);
    $.ajax({
        url: "<?php echo site_url('Systems/Permissions/Get_permission?id='); ?>" + val,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            document.getElementById('role_user').innerHTML = data.value[0].grup_nama;
            if (data.status) {
                $('#tbl_access').DataTable({
                    "retrieve": true,
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "processing": false,
                    "deferRender": false,
                    "data": data.value,
                    columns: [
                        {data: 'nama_menu', title: "MENU"},
                        {
                            title: "VIEW",
                            data: null,
                            className: "text-center",
                            "searchable": false,
                            render: function (data) {
                                var a;
                                if (data.view == 1) {
                                    a = '<input type="checkbox" id="view_menu' + data.id_menu + '" name="view_menu[]" value="1" checked="" onclick="V_menu(' + data.id_menu + ')"/>';
                                } else {
                                    a = '<input type="checkbox" id="view_menu' + data.id_menu + '" name="view_menu[]" value="0" onclick="V_menu(' + data.id_menu + ')"/>';
                                }
                                return a + '<input type="hidden" name="id_menu[]" value="' + data.id_menu + '"/>';
                            }
                        },
                        {
                            title: "CREATE",
                            data: null,
                            className: "text-center",
                            render: function (data) {
                                var a;
                                if (data.create == 1) {
                                    a = '<input type="checkbox" id="create_menu' + data.id_menu + '" name="create_menu[]" value="1" checked="" onclick="C_menu(' + data.id_menu + ')"/>';
                                } else {
                                    a = '<input type="checkbox" id="create_menu' + data.id_menu + '" name="create_menu[]" value="0" onclick="C_menu(' + data.id_menu + ')"/>';
                                }
                                return a;
                            }
                        },
                        {
                            title: "READ",
                            data: null,
                            className: "text-center",
                            render: function (data) {
                                var a;
                                if (data.read == 1) {
                                    a = '<input type="checkbox" id="read_menu' + data.id_menu + '" name="read_menu[]" value="1" checked="" onclick="R_menu(' + data.id_menu + ')"/>';
                                } else {
                                    a = '<input type="checkbox" id="read_menu' + data.id_menu + '" name="read_menu[]" value="0" onclick="R_menu(' + data.id_menu + ')"/>';
                                }
                                return a;
                            }
                        },
                        {
                            title: "UPDATE",
                            data: null,
                            className: "text-center",
                            render: function (data) {
                                var a;
                                if (data.update == 1) {
                                    a = '<input type="checkbox" id="update_menu' + data.id_menu + '" name="update_menu[]" value="1" checked="" onclick="U_menu(' + data.id_menu + ')"/>';
                                } else {
                                    a = '<input type="checkbox" id="update_menu' + data.id_menu + '" name="update_menu[]" value="0" onclick="U_menu(' + data.id_menu + ')"/>';
                                }
                                return a;
                            }
                        },
                        {
                            title: "DELETE",
                            data: null,
                            className: "text-center",
                            render: function (data) {
                                var a;
                                if (data.delete == 1) {
                                    a = '<input type="checkbox" id="delete_menu' + data.id_menu + '" name="delete_menu[]" value="1" checked="" onclick="D_menu(' + data.id_menu + ')"/>';
                                } else {
                                    a = '<input type="checkbox" id="delete_menu' + data.id_menu + '" name="delete_menu[]" value="0" onclick="D_menu(' + data.id_menu + ')"/>';
                                }
                                return a;
                            }
                        }
                    ]
                });
            } else {

            }
        }, error: function (data) {
            Swal.fire("Error " + data.status, data.statusText, "error");
        }
    });
}
function Close_modal() {
    var table = $('#tbl_access').DataTable();
    table.destroy().empty();

}
function V_menu(val) {
    var c, r, u, d;
    c = $("#create_menu" + val);
    r = $("#read_menu" + val);
    u = $("#update_menu" + val);
    d = $("#delete_menu" + val);
    if ($("#view_menu" + val).prop('checked') == true) {
        document.getElementById("view_menu" + val).value = 1;
    } else {
        document.getElementById("view_menu" + val).value = 0;
        c.prop('checked', false);
        r.prop('checked', false);
        u.prop('checked', false);
        d.prop('checked', false);
    }
}
function C_menu(val) {
    var view_menu = $("#view_menu" + val).val();
    if (view_menu == 0) {
        $("#create_menu" + val).prop('checked', false);
        toastr.warning('you cannot select this without view access!');
        document.getElementById("create_menu" + val).value = 0;
    } else if ($("#create_menu" + val).prop('checked') == true) {
        document.getElementById("create_menu" + val).value = 1;
    } else {
        document.getElementById("create_menu" + val).value = 0;
    }
}
function R_menu(val) {
    var view_menu = $("#view_menu" + val).val();
    if (view_menu == 0) {
        $("#read_menu" + val).prop('checked', false);
        toastr.warning('you cannot select this without view access!');
        document.getElementById("read_menu" + val).value = 0;
    } else if ($("#read_menu" + val).prop('checked') == true) {
        document.getElementById("read_menu" + val).value = 1;
    } else {
        document.getElementById("read_menu" + val).value = 0;
    }
}
function U_menu(val) {
    var view_menu = $("#view_menu" + val).val();
    var read_menu = $("#read_menu" + val).val();
    if (view_menu == 0 & read_menu == 0) {
        $("#update_menu" + val).prop('checked', false);
        toastr.warning('you cannot select this without view access!');
        document.getElementById("update_menu" + val).value = 0;
    } else if (read_menu == 0 & view_menu == 1) {
        $("#update_menu" + val).prop('checked', false);
        toastr.warning('you cannot select this without read access!');
        document.getElementById("update_menu" + val).value = 0;
    } else if ($("#update_menu" + val).prop('checked') == true) {
        document.getElementById("update_menu" + val).value = 1;
    } else {
        document.getElementById("update_menu" + val).value = 0;
    }
}
function D_menu(val) {
    var view_menu = $("#view_menu" + val).val();
    var read_menu = $("#read_menu" + val).val();
    if (view_menu == 0 & read_menu == 0) {
        $("#delete_menu" + val).prop('checked', false);
        toastr.warning('you cannot select this without view access!');
        document.getElementById("delete_menu" + val).value = 0;
    } else if (read_menu == 0 & view_menu == 1) {
        $("#delete_menu" + val).prop('checked', false);
        toastr.warning('you cannot select this without read access!');
        document.getElementById("delete_menu" + val).value = 0;
    } else if ($("#delete_menu" + val).prop('checked') == true) {
        document.getElementById("delete_menu" + val).value = 1;
    } else {
        document.getElementById("delete_menu" + val).value = 0;
    }
}
function Save() {
    $('#modal_access').modal('hide');
    $(':checkbox').each(function () {
        this.checked = true;
    });
}
function Close_edit() {
    document.getElementById('modal_editLabel').innerHTML = '';
    $('input[name="gr_name_edit"]').val('');
    $('input[name="id_grup_edit"]').val('');
    $('textarea[name="gr_desc_edit"]').val('');
    $('#gr_parent_edit').val(null).trigger('change');
}