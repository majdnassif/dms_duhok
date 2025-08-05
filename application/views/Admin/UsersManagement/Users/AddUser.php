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
                <form id="AddUserForm" class="col-12">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="NAME"><?= $this->Dictionary->GetKeyword('NAME') ?>*</label>
                            <input id='NAME' name='NAME' aria-describedby="helpNAME" class="form-control" type="text" required>
                            <small id="helpNAME" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-6 " style="direction: ltr !important;">
                            <label for="LOGIN"><?= $this->Dictionary->GetKeyword('LOGIN') ?>*</label>
                            <input id='LOGIN' style="direction: ltr !important;" name='LOGIN' aria-describedby="helpLOGIN" class="form-control" type="text" required>
                            <small id="helpLOGIN" class="form-text text-danger"></small>
                        </div>

                        <div class="form-group col-6 " style="direction: ltr !important;">
                            <label for="telephone"><?= $this->Dictionary->GetKeyword('phone') ?>*</label>
                            <input id='telephone' name='telephone' style="direction: ltr !important;" data-inputmask="'mask': ['0999-999-9999 [x99999]']" data-mask aria-describedby="helptelephone" class="form-control" type="text">
                            <small id="helptelephone" class="form-text text-danger"></small>
                        </div>
                        <!-- UI_LANGUAGE select from lang_array -->
                        <div class="form-group col-6">
                            <label for="UI_LANGUAGE"><?= $this->Dictionary->GetKeyword('UI_LANGUAGE') ?>*</label>
                            <select id="UI_LANGUAGE" name="UI_LANGUAGE" class="form-control select2" required>
                                <?php foreach (lang_array() as $lang=>$LangName) : ?>
                                    <option value="<?= $lang ?>"><?= $LangName ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="helpUI_LANGUAGE" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-12 " style="direction: ltr !important;">
                            <label for="groups"><?= $this->Dictionary->GetKeyword('groups') ?>*</label>
                            <select id='groups' name='groups[]' aria-describedby="helpgroups" class="form-control select2" required multiple>
                                <option value=""><?= $this->Dictionary->GetKeyword('select') ?></option>
                                <?php foreach ($Groups as $group) : ?>
                                    <option value="<?= $group['GROUP_ID'] ?>"><?= $group['GROUP_NAME'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small id="helpgroups" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-6">
                            <label for="PASSWORD"><?= $this->Dictionary->GetKeyword('PASSWORD') ?></label>
                            <div class="input-group" style="direction: ltr !important;">
                                <input id='PASSWORD' style="direction: ltr !important;" name='PASSWORD' aria-describedby="helpPASSWORD" class="form-control" type="password" data-toggle="password">
                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-eye"></i></span></div>
                            </div>
                            <small id="helpPASSWORD" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-6">
                            <label for="PASSWORD_CONFIRM"><?= $this->Dictionary->GetKeyword('PASSWORD_CONFIRM') ?></label>
                            <div class="input-group" style="direction: ltr !important;">
                                <input id='PASSWORD_CONFIRM' style="direction: ltr !important;" name='PASSWORD_CONFIRM' aria-describedby="helpPASSWORD_CONFIRM" class="form-control" type="password" data-toggle="password">
                                <div class="input-group-append"><span class="input-group-text"><i class="fa fa-eye"></i></span></div>
                            </div>
                            <small id="helpPASSWORD_CONFIRM" class="form-text text-danger"></small>
                        </div>
                        <div class="form-group col-md-12">
                                    <label for="user_access_department_id"><?= $this->Dictionary->GetKeyword('user_access_department')?></label>
                                    <input type="text" class="form-control" id="location" value="" onclick="OpenTree('contracts_unit_locations','location','user_access_department_id','1')" readonly="">
                                    <input type="hidden" class="form-control" id="user_access_department_id" name="user_access_department_id" value="4">
                        </div>
                        <div class="form-group col-12 text-center">
                            <!-- submit -->
                            <button type="submit" class="btn btn-success"><?= $this->Dictionary->GetKeyword('Save') ?></button>
                            <a href="<?=base_url('UsersManagement/UsersList')?>" class="btn btn-default"><?= $this->Dictionary->GetKeyword('Close') ?></a>
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
    //functions for strong password
    var LOWER = /[a-z]/,
        UPPER = /[A-Z]/,
        DIGIT = /[0-9]/,
        DIGITS = /[0-9].*[0-9]/,
        SPECIAL = /[^a-zA-Z0-9]/,
        SAME = /^(.)\1+$/;

    function rating(rate, message) {
        return {
            rate: rate,
            messageKey: message
        };
    }

    function passwordRating(password, username) {
        if (!password || password.length < 8)
            return rating(0, "too short");
        /* if (username && password.toLowerCase().match(username.toLowerCase()))
            return rating(0, "similar to username"); */
        if (SAME.test(password))
            return rating(1, "very weak");

        var lower = LOWER.test(password),
            upper = UPPER.test(password),
            digit = DIGIT.test(password),
            special = SPECIAL.test(password);
        //digits = DIGITS.test(password),

        if (lower && upper && digit && special) {
            return rating(4, "strong");
        } else {
            return rating(2, "weak");
        }
    }
    
    $(document).ready(function() {
        $.validator.addMethod("check_password", function(value, element, usernameField) {
        errorElement = $(element).closest('.form-group').find('small');
        // use untrimmed value
        var password = element.value,
            // get username for comparison, if specified
            username = $(typeof usernameField != "boolean" ? usernameField : []);

        if (password.length == 0) {
            $(errorElement).siblings("#messageKey").remove();
            return true;
        } else {
            var rating = passwordRating(password, username.val());

            $(errorElement).siblings("#messageKey").remove();
            if (rating.rate < 4) {
                //invalid
                $(errorElement).text(rating.messageKey);
                $('<span id="messageKey" class="text-danger">' + rating.messageKey + '</span>').insertAfter(errorElement);
            }
            return rating.rate > 3;
        }
    }, "&nbsp;");
        $('#AddUserForm').validate({
            ignore: "",
            rules: {
                NAME:{
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                PASSWORD: {
                    minlength: 6,
                    check_password: "#LOGIN"
                    //required: true
                },
                PASSWORD_CONFIRM: {
                    minlength: 6,
                    equalTo: '[name="PASSWORD"]'
                }
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
        $("[data-mask]").inputmask();
        $('#AddUserForm').submit(function() {
            if ($('#AddUserForm').valid()) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('UsersManagement/AddUser/'); ?>",
                    data: $('#AddUserForm').serialize(),
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 'success') {
                            //redirect to UsersManagement/UsersList
                            window.location.href = "<?= base_url('UsersManagement/UsersList'); ?>";
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