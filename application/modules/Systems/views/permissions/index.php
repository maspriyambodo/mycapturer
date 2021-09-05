<style type="text/css">
    #tbl_access th {
        background: white;
        position: sticky;
        top: 0;
    }
</style>
<div class="card card-custom">
    <div class="card-body">
        <?php
        if ($privilege['create']) {
            echo '<div class="form-group text-right">'
            . '<div id="btnadd" class="btn btn-icon btn-primary" title="add new group" data-toggle="modal" data-target="#modal_add"><i class="far fa-plus-square"></i></div>'
            . '</div>';
            require_once 'modal_add.php';
        }
        ?>
        <div class="table-responsive">
            <table id="tbl_role" class="table table-bordered table-hover table-striped" style="width:100%;">
                <thead class="text-center text-uppercase">
                    <tr>
                        <th>no</th>
                        <th>group id</th>
                        <th>parent</th>
                        <th>name</th>
                        <th>description</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$privilege['read']) {
                        $data = [];
                    }
                    foreach ($data as $a) {
                        $id_grup = str_replace(['+', '/', '='], ['-', '_', '~'], $this->encryption->encrypt($a->id_grup));
                        ?>
                        <tr>
                            <td class="text-center">
                                <?php
                                static $id = 1;
                                echo $id++;
                                ?>
                            </td>
                            <td class="text-center"><?php echo $a->id_grup; ?></td>
                            <td>
                                <?php
                                if ($a->parent_name == null) {
                                    echo 'parent';
                                } else {
                                    echo $a->parent_name;
                                }
                                ?>
                            </td>
                            <td><?php echo $a->nama_grup; ?></td>
                            <td><?php echo $a->des_grup; ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <?php
                                    $editbtn = '<button id="editbtn" type="button" class="btn btn-icon btn-default btn-xs" title="Edit Group ' . $a->nama_grup . '" value="' . $id_grup . '" onclick="Edit(this.value)"><i class="far fa-edit"></i></button>';
                                    $editbtn2 = '<button id="permissionsbtn" type="button" class="btn btn-icon btn-primary btn-xs" title="Edit Permissions ' . $a->nama_grup . '" value="' . $id_grup . '" data-toggle="modal" data-target="#modal_access" onclick="Get_access(this.value)"><i class="fas fa-cog"></i></button>';
                                    $delbtn = '<button id="delbtn" type="button" class="btn btn-icon btn-danger btn-xs" title="Delete ' . $a->nama_grup . '" value="' . $id_grup . '" data-toggle="modal" data-target="#modal_delete" onclick="Delete_group(this.value)"><i class="far fa-trash-alt"></i></button>';
                                    if ($privilege['update']) {
                                        echo $editbtn;
                                        echo $editbtn2;
                                    }
                                    if ($privilege['delete']) {
                                        echo $delbtn;
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<input type="hidden" name="err_msg" value="<?php echo $this->session->flashdata('err_msg'); ?>"/>
<input type="hidden" name="succ_msg" value="<?php echo $this->session->flashdata('succ_msg'); ?>"/>
<?php
if ($privilege['update']) {
    require_once 'modal_access.php';
    require_once 'modal_edit.php';
}
if ($privilege['delete']) {
    require_once 'modal_delete.php';
}
unset($_SESSION['err_msg']);
unset($_SESSION['succ_msg']);
?>
<script>
    window.onload = function () {
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
        $('#tbl_role').dataTable({
            "ServerSide": true,
            "order": [[0, "asc"]],
            "paging": true,
            "ordering": true,
            "info": true,
            "processing": true,
            "deferRender": true,
            "scrollCollapse": true,
            "scrollX": true,
            "scrollY": "400px",
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                <'row'<'col-sm-12'tr>>
                <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            buttons: [
                {extend: 'print', footer: true},
                {extend: 'copyHtml5', footer: true},
                {extend: 'excelHtml5', footer: true},
                {extend: 'csvHtml5', footer: true},
                {extend: 'pdfHtml5', footer: true}
            ]
        });
        $('.custom-select').select2();
    };
<?php require_once 'permisi.js'; ?>
</script>