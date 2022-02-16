<div class="card card-custom">
    <div class="card-body">
        <form action="<?php echo base_url('Systems/Import_Excel/Upload/'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $csrf['name'] ?>" value="<?php echo $csrf['hash'] ?>"/>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Upload File:</label>
                        <input type="file" name="dbtxt" class="form-control" accept=".xlsx, .xls" required=""/>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </form>
    </div>
</div>