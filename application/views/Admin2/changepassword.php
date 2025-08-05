<!DOCTYPE html>
<html>
<head>

    <!-- Title -->
    <title><?=sys_info()['title']?> | Change Password</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <meta name="description" content="Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />

    <!-- Styles -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="<?=base_url('assets/admin2/')?>plugins/pace-master/themes/blue/pace-theme-flash.css" rel="stylesheet"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/uniform/css/uniform.default.min.css" rel="stylesheet"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/line-icons/simple-line-icons.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/offcanvasmenueffects/css/menu_cornerbox.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/waves/waves.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/switchery/switchery.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>plugins/3d-bold-navigation/css/style.css" rel="stylesheet" type="text/css"/>

    <!-- Theme Styles -->
    <link href="<?=base_url('assets/admin2/')?>css/modern.css" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>css/themes/green.css" class="theme-color" rel="stylesheet" type="text/css"/>
    <link href="<?=base_url('assets/admin2/')?>css/custom.css" rel="stylesheet" type="text/css"/>

    <script src="<?=base_url('assets/admin2/')?>plugins/3d-bold-navigation/js/modernizr.js"></script>
    <script src="<?=base_url('assets/admin2/')?>plugins/offcanvasmenueffects/js/snap.svg-min.js"></script>

    <link href="<?=base_url('assets/admin2/');?>plugins/toastr/toastr.min.css" rel="stylesheet" type="text/css"/>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .input-group-append-2 {
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1;
            color: #555;
            text-align: center;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-group-append-2  .input-group-btn {
            width: 1%;
            white-space: nowrap;
            vertical-align: middle;
        }
    </style>
</head>
<body class="page-login">
<main class="page-content">
    <div class="page-inner">
        <div id="main-wrapper">
            <div class="row">
                <div class="col-md-3 center">
                    <div class="login-box">
                        <a href="<?=base_url();?>" class="logo-name text-lg text-center"><?=sys_info()['name']?></a>

                        <div class="alert alert-info text-right" dir="rtl" style="font-size: 14px; white-space: pre-line;">
                            <strong>رێنمایی گۆرینی سیستەمی DMS</strong><br>
                            1. هەموو بەکارهینەران بەهەمان لینك و بە هەمان ناوی بەکارهێنەر و ووشەی تێپەر لە سیستەمی نوێ کار دەکات.<br>
                            2. بۆ یەکەم جار داوای گۆرینی ووشەی تێپەر لە بەکارهێنەر دەکات.<br>
                            3. ووشەی تێپەری نوێ دەبێت لە 8 پیت کەمتر نەبێت و پیتی گەورە و بچووك و ژمارە و سمبل پێك دێت Aa#1.<br>
                            4. بۆ دەستکاری کردنی رێگە پێدانەکان لە سیستەمە نوێیەکە تکایە پەیوەندی بە بەشی IT وەزارەت بکرێت.<br>
                            5. بۆ هەر کێشەیەكی تەکنیکی تکایە ئاگاداری کۆمپانیا بکەنەوە.
                        </div>

                        <form id="EditUserPassword" class="m-t-md">
                            <div class="form-group col-12">
                                <label for="PASSWORD"><?=$this->Dictionary->GetKeyword('PASSWORD')?></label>
                                <div class="input-group" style="direction: ltr !important;">
                                    <input id='PASSWORD' style="direction: ltr !important;" name='PASSWORD' aria-describedby="helpPASSWORD" class="form-control" type="password" data-toggle="password">
                                    <div class="input-group-addon"><span class="input-group-text input-password-hide"><i class="fa fa-eye"></i></span></div>
                                </div>
                                <small id="helpPASSWORD" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group col-12">
                                <label for="PASSWORD_CONFIRM"><?=$this->Dictionary->GetKeyword('PASSWORD_CONFIRM')?></label>
                                <div class="input-group" style="direction: ltr !important;">
                                    <input id='PASSWORD_CONFIRM' style="direction: ltr !important;" name='PASSWORD_CONFIRM' aria-describedby="helpPASSWORD_CONFIRM" class="form-control" type="password" data-toggle="password">
                                    <div class="input-group-addon"><span class="input-group-text input-password-hide"><i class="fa fa-eye"></i></span></div>
                                </div>
                                <small id="helpPASSWORD_CONFIRM" class="form-text text-danger"></small>
                            </div>
                            <?php if(isset($message)):?>
                                <div class="alert alert-danger"><?=$message;?></div>
                            <?php endif;?>
                            <button type="submit" class="btn btn-success btn-block"><?=$this->Dictionary->GetKeyword('Save')?></button>
                        </form>

                        <!--                                <img style="margin-top: 20px;" class="img-fluid" src="--><?php //=sys_info()['login_logo']?><!--" alt="">-->
                    </div>
                </div>
            </div><!-- Row -->
        </div><!-- Main Wrapper -->
    </div><!-- Page Inner -->
    </div><!-- Main Wrapper -->
    </div><!-- Page Inner -->
</main><!-- Page Content -->


<!-- Javascripts -->
<script src="<?=base_url('assets/admin2/')?>plugins/jquery/jquery-2.1.4.min.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/switchery/switchery.min.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/uniform/jquery.uniform.min.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/offcanvasmenueffects/js/classie.js"></script>
<script src="<?=base_url('assets/admin2/')?>plugins/waves/waves.min.js"></script>
<script src="<?=base_url('assets/admin2/')?>js/modern.min.js"></script>

<script src="<?=base_url('assets/dist/js/')?>bootstrap-show-password.min.js"></script>

<script src="<?=base_url('assets/admin2/');?>plugins/jquery-validation/jquery.validate.min.js" ></script>


<script src="<?=base_url('assets/');?>plugins/toastr/toastr.min.js"></script>


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
    function passwordRating(password) {
        if (!password || password.length < 8)
            return rating(0, "too short");

        if (SAME.test(password))
            return rating(1, "very weak");

        var lower = LOWER.test(password),
            upper = UPPER.test(password),
            digit = DIGIT.test(password),
            special = SPECIAL.test(password);
        //digits = DIGITS.test(password),

        if (lower && upper && digit && special){
            return rating(4, "strong");
        }else{
            return rating(2, "weak");
        }
    }

    $.validator.addMethod("check_password", function(value, element, usernameField) {
        errorElement=$(element).closest('.form-group').find('small');
        // use untrimmed value
        var password = element.value,
            // get username for comparison, if specified
            username = $(typeof usernameField != "boolean" ? usernameField : []);

        if(password.length == 0){
            $(errorElement).siblings("#messageKey").remove();
            return true;
        }else{
            var rating = passwordRating(password);

            $(errorElement).siblings("#messageKey").remove();
            if(rating.rate < 4){
                //invalid
                $(errorElement).text(rating.messageKey);
                $('<span id="messageKey" class="text-danger">'+rating.messageKey+'</span>').insertAfter(errorElement);
            }
            return rating.rate > 3;
        }
    }, "&nbsp;");
    $(document).ready(function() {
        $('#EditUserPassword').validate({
            ignore: "",
            rules: {
                PASSWORD : {
                    required: true,
                    minlength : 6,
                    check_password: true
                    //required: true
                },
                PASSWORD_CONFIRM : {
                    minlength : 6,
                    equalTo : '[name="PASSWORD"]'
                }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            success: function(element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').find('small').html(error.html());
            }
        });


        $('#EditUserPassword').on('submit', function(e) {

            e.preventDefault(); // stop default form submit early

            if ($(this).valid()) {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url('admin/changepassword');?>",
                    data: $('#EditUserPassword').serialize(),
                    success: function(response) {
                        console.log('responseeeeeeeeeeee', response);
                        response=JSON.parse(response);
                        console.log('responseeeeeeeeeeeedddd', response);
                        if(response.status=='success'){
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = '<?= base_url('admin/Dashboard') ?>';
                            }, 1000); // Delay for 1 second to show the toast
                        }else{
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        console.log('errrorrrrr');
                        toastr.error("we have n't updated the information");
                    }
                });
            }
            return false;
        });

    });
</script>
</body>
</html>
</html>