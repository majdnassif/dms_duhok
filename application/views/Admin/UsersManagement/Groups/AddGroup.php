<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php if (isset($page_title)) : ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><?= $this->Dictionary->GetKeyword($page_title); ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><?= $this->Dictionary->GetKeyword('Home'); ?></a></li>
                            <li class="breadcrumb-item active"><?= $this->Dictionary->GetKeyword($page_title); ?></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    <?php endif; ?>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title" dir=''><?= $this->Dictionary->GetKeyword($page_card_title) ?></h3>
            </div>
            <div class="card-body p-4 table-responsive">
                <form id="AddGroupForm" class="col-12">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="GROUP_NAME"><?= $this->Dictionary->GetKeyword('GROUP_NAME') ?>*</label>
                            <input id='GROUP_NAME' name='GROUP_NAME' aria-describedby="helpGROUP_NAME" class="form-control" type="text" required>
                            <small id="helpGROUP_NAME" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-6">
                            <label for="STATUS_ID"><?= $this->Dictionary->GetKeyword('STATUS') ?>*</label>
                            <select id="STATUS_ID" name="STATUS_ID" class="form-control select2" required>
                                <option value="1"><?= $this->Dictionary->GetKeyword('active') ?></option>
                                <option value="0"><?= $this->Dictionary->GetKeyword('inactive') ?></option>
                            </select>
                            <small id="helpUI_LANGUAGE" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-12">
                        
                        <select class="duallistbox" name="PERMISSION[]" multiple="multiple">
                            <?php foreach($Operations as $Operation):?>
                            <option value="<?=$Operation['OPERATION_CODE']?>"><?=$Operation['NAME']?></option>
                            <?php endforeach;?>
                        </select>
                        </div>
                        <div class="form-group col-12 text-center">
                            <!-- submit -->
                            <button type="submit" class="btn btn-success"><?= $this->Dictionary->GetKeyword('Save') ?></button>
                            <a href="<?=base_url('UsersManagement/GroupsList')?>" class="btn btn-default"><?= $this->Dictionary->GetKeyword('Close') ?></a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
        <script src="<?=base_url('assets/dist/js/')?>bootstrap-show-password.min.js"></script>
<script>


    
    $(document).ready(function() {
        $('#AddGroupForm').validate({
            ignore: "",
            rules: {
                GROUP_NAME:{
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
            },
            highlight: function(element) {
                $(element).removeClass('is-valid');
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            success: function(element) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').find('small').html(error.html());
            }
        });
        $('.select2').select2({
            theme: 'bootstrap4'
        });
            //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox({
            infoText: 'Showing all {0}',
            selectorMinimalHeight: 250,
        });
        $('#AddGroupForm').submit(function() {
            if ($('#AddGroupForm').valid()) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('UsersManagement/AddGroup/'); ?>",
                    data: $('#AddGroupForm').serialize(),
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 'success') {
                            //redirect to UsersManagement/UsersList
                            window.location.href = "<?= base_url('UsersManagement/GroupsList'); ?>";
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error("we have n't updated the information");
                    }
                });
            }
            return false;
        });

    });
</script>

<!-- Bootstrap4 Duallistbox -->
<script src="<?=base_url('assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')?>"></script>