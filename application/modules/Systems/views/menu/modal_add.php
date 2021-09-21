<div class="modal fade" id="modal_add" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal_add" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="fas fa-times"></i>
                </button>
            </div>
            <form action="<?php echo base_url('Systems/Menu/Save/'); ?>" method="post">
                <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="menu_parent">Parent:</label>
                                <select id="menu_parent" class="form-control custom-select" name="menu_parent">
                                    <option value="">Parent</option>
                                    <?php foreach ($data as $key => $menu_parent) { ?>
                                        <option value="<?php echo Enkrip($menu_parent->id_menu); ?>"><?php echo $menu_parent->nama_menu; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="gr_menu">Group:</label>
                                <select id="gr_menu" class="form-control custom-select" required="" name="gr_menu" onchange="Get_order(this.value)">
                                    <option value="">Choose Group</option>
                                    <?php
                                    foreach ($name_group as $name_group) {
                                        echo '<option value="' . Enkrip($name_group->id) . '">' . $name_group->nama . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="order_no">Order:</label>
                                <select id="order_no" name="order_no" required="" class="form-control custom-select"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label for="link_menu">Location:</label>
                                <input id="link_menu" type="text" name="link_menu" class="form-control" autocomplete="off" required="" placeholder="Systems/Order/index/"/>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="nama_menu">Menu:</label>
                                <input id="nama_menu" type="text" name="nama_menu" class="form-control" autocomplete="off" required="" placeholder="Order history"/>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label for="ico_menu">Icon:</label>
                                <input id="ico_menu" type="text" name="ico_menu" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc_txt">Description:</label>
                        <textarea name="desc_txt" id="desc_txt" class="form-control" required="" maxlength="250"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal"><i class="far fa-times-circle"></i> Close</button>
                    <button type="submit" class="btn btn-primary font-weight-bold"><i class="far fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function Get_order(val) {
        $('#order_no').empty();
        $.ajax({
            url: "<?php echo site_url('Systems/Menu/Get_order?id='); ?>" + val,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.length) {
                    var i;
                    for (i = 0; i < data.length; i++) {
                        var sel = document.getElementById("order_no");
                        var opt = document.createElement("option");
                        opt.value = data[i].order_no;
                        opt.text = "After " + data[i].nama_menu;
                        sel.add(opt, sel.options[i]);
                    }
                } else {
                    var sel = document.getElementById("order_no");
                    var opt = document.createElement("option");
                    opt.value = 'undefined';
                    opt.text = 'First';
                    sel.add(opt, sel.options[0]);
                }
            }, error: function (jqXHR) {
                toastr.warning('error ' + jqXHR.status + ' ' + jqXHR.statusText);
            }
        });
    }
</script>