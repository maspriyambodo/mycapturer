<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" integrity="sha512-+EoPw+Fiwh6eSeRK7zwIKG2MA8i3rV/DGa3tdttQGgWyatG/SkncT53KHQaS5Jh9MNOT3dmFL0FjTY08And/Cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js" integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="card card-custom">
    <div class="card-body">
        <?php
        if ($privilege['create']) { // jika memiliki privilege tambah data / create
            echo '<div class="text-right">'
            . '<div class="form-group">'
            . '<a href="' . base_url('Compro/Gallery/Add/') . '" class="btn btn-primary mr-2"><i class="far fa-plus-square"></i> Add new</a>'
            . '</div>'
            . '</div>';
        } else {
            null;
        }
        ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped" style="width:100%;">
                <thead class="text-center text-uppercase">
                    <tr>
                        <th>no</th>
                        <th>type</th>
                        <th>title</th>
                        <th>thumbnail</th>
                        <th>description</th>
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
    require_once 'modal_activate.php';
} else {
    null;
}
unset($_SESSION['err_msg']);
unset($_SESSION['succ_msg']);
?>
<script>
    window.onload = function () {
        $('#sticky_toolbar').attr('class', 'sticky-toolbar nav flex-column pl-2 pr-2 pt-3 pb-3 mt-4');
        $('#sticky_toolbar').append(
                '<li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-placement="left" title="view website"> <a class="btn btn-sm btn-icon btn-bg-light btn-icon-success btn-hover-success" href="<?php echo base_url('Profile/index/'); ?>" target="new"> <i class="fas fa-globe"></i> </a> </li>'
                );
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
        if (a) {
            toastr.error(a);
        } else if (b) {
            toastr.success(b);
        }
        $('table').dataTable({
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
                {extend: 'print', footer: true, orientation: 'landscape', pageSize: 'LEGAL'},
                {extend: 'excelHtml5', footer: true},
                {extend: 'pdfHtml5', footer: true, orientation: 'landscape', pageSize: 'LEGAL'}
            ],
            lengthMenu: [
                [10, 50, 100, 500, -1],
                ['10', '50', '100', '500', 'all']
            ],
            "ajax": {
                "url": "Compro/Gallery/Lists/",
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
                    orderable: false
                },
                {
                    targets: 5,
                    className: 'text-center'
                },
                {
                    targets: 6,
                    className: 'text-center',
                    orderable: false
                }
            ]
        });
    };
    function Gallery(param) {
        var tipe;
        if (param == 'image') {
            tipe = 'image';
        } else {
            tipe = 'iframe';
        }
        $('.image-link').magnificPopup({
            type: tipe
        });
    }
    function Edit(id) {
        window.location.href = '<?php echo base_url('Compro/Gallery/Edit?token='); ?>' + id;
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