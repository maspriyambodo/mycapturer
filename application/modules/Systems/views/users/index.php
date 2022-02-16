<div class="card card-custom">
    <div class="card-body">
        <?php
        if ($privilege['create']) {
            echo '<div class="text-right">'
            . '<div class="form-group">'
            . '<button id="add_user" type="button" class="btn btn-icon btn-primary" title="Add new user" onclick="Add_user()"><i class="fas fa-user-plus"></i></button>'
            . '</div>'
            . '</div>';
        } else {
            null;
        }
        ?>
        <div class="table-responsive">
            <table id="table" class="table table-bordered table-hover table-striped" style="width:100%;">
                <thead class="text-center text-uppercase">
                    <tr>
                        <th>no</th>
                        <th>username</th>
                        <th>roles</th>
                        <th>status</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<input type="hidden" name="err_msg" value="<?php echo $this->session->flashdata('err_msg'); ?>"/>
<input type="hidden" name="succ_msg" value="<?php echo $this->session->flashdata('succ_msg'); ?>"/>
<?php
if ($privilege['delete']) {
    require_once 'modal_delete.php';
    require_once 'modal_active.php';
    require_once 'modal_reset.php';
}
unset($_SESSION['err_msg']);
unset($_SESSION['succ_msg']);
?>
<script>
    window.onload = function () {
        $('#table').dataTable({
            "serverSide": true,
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
            ],
            lengthMenu: [
                [10, 50, 100, 500, -1],
                ['10', '50', '100', '500', 'all']
            ],
            "ajax": {
                "url": "Systems/Users/lists",
                "type": "GET"
            },
            columnDefs: [
                {
                    targets: 0,
                    className: 'text-center'
                },
                {
                    targets: 3,
                    className: 'text-center',
                    orderable: false
                },
                {
                    targets: 4,
                    className: 'text-center',
                    orderable: false
                }
            ]
        });
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
    };
    function Add_user() {
        window.location.href = "<?php echo base_url('Systems/Users/Add/'); ?>";
    }
    function Delete(val) {
        $('input[name="e_id"]').val(val);
        $('#modal_delete').modal({show: true, backdrop: 'static', keyboard: false});
    }
    function Close_delmodal() {
        $('input[name="e_id"]').val("");
    }
    function Active(id) {
        $('input[name="act_id"]').val(id);
        $('#modal_active').modal({show: true, backdrop: 'static', keyboard: false});
    }
    function Edit(id) {
        window.location.href = "<?php echo base_url('Systems/Users/Edit?id='); ?>" + id;
    }
</script>