        <style>
            .bootstrap-switch{
                direction: ltr !important;
            }
            .bootstrap-switch.bootstrap-switch-animate .bootstrap-switch-container {
                    direction: ltr !important;
                }
        </style>
        <form id="EditProfileUser" method="POST">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title"><?=$this->Dictionary->GetKeyword('edit profile')?></h3>
            </div>
            <div class="modal-body">
                <input type="hidden" name="user_id" value="<?=$this->UserModel->user_id()?>">
                <div class="form-group col-12">
                    <label for="NAME"><?=$this->Dictionary->GetKeyword('NAME')?>*</label>
                    <input id='NAME' name='NAME' <?php if(isset($UserInfo['NAME'])){echo 'value="'.$UserInfo['NAME'].'"';}?> aria-describedby="helpNAME" class="form-control" type="text" required>
                    <small id="helpNAME" class="form-text text-danger"></small>
                </div>
                <div class="form-group col-12 " style="direction: ltr !important;">
                    <label for="LOGIN"><?=$this->Dictionary->GetKeyword('LOGIN')?>*</label>
                    <input id='LOGIN' style="direction: ltr !important;" name='LOGIN' <?php if(isset($UserInfo['LOGIN'])){echo 'value="'.$UserInfo['LOGIN'].'"';}?> aria-describedby="helpLOGIN" class="form-control" type="text" required>
                    <small id="helpLOGIN" class="form-text text-danger"></small>
                </div>
                
                <div class="form-group col-12 "  style="direction: ltr !important;">
                    <label for="telephone"><?=$this->Dictionary->GetKeyword('phone')?>*</label>
                    <input id='telephone' name='telephone'  style="direction: ltr !important;" data-inputmask="'mask': ['0999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask <?php if(isset($UserInfo['telephone'])){echo 'value="'.$UserInfo['telephone'].'"';}?> aria-describedby="helptelephone" class="form-control" type="text">
                    <small id="telephone" class="form-text text-danger"></small>
                </div>
                <div class="form-group col-12 "  style="direction: ltr !important;">
                <label for="google_authenticator"><?=$this->Dictionary->GetKeyword('google_authenticator')?></label><br>
                <input type="checkbox" name="google_auth" value="1" id="google_authenticator" style="direction: ltr !important;" <?php if($UserInfo['google_auth']==1){echo 'checked';}?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
                </div>
                <div class="form-group col-12">
                        <img class="img-fluid border" src="<?= $user_2fa_qrCode ?>" />
                </div>
                <div class="form-group col-12">
                     <label for="PASSWORD"><?=$this->Dictionary->GetKeyword('PASSWORD')?></label>
                    <div class="input-group" style="direction: ltr !important;">
                    <input id='PASSWORD' style="direction: ltr !important;" name='PASSWORD' aria-describedby="helpPASSWORD" class="form-control" type="password" data-toggle="password">
                        <div class="input-group-addon"><span class="input-group-text"><i class="fa fa-eye"></i></span></div>
                    </div>
                    <small id="helpPASSWORD" class="form-text text-danger"></small>
                </div>
                <div class="form-group col-12">
                    <label for="PASSWORD_CONFIRM"><?=$this->Dictionary->GetKeyword('PASSWORD_CONFIRM')?></label>
                    <div class="input-group" style="direction: ltr !important;">
                    <input id='PASSWORD_CONFIRM' style="direction: ltr !important;" name='PASSWORD_CONFIRM' aria-describedby="helpPASSWORD_CONFIRM" class="form-control" type="password" data-toggle="password">
                    <div class="input-group-addon"><span class="input-group-text"><i class="fa fa-eye"></i></span></div>
                    </div>
                    <small id="helpPASSWORD_CONFIRM" class="form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer col-12 justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?=$this->Dictionary->GetKeyword('Close')?></button>
              <button type="submit"  class="btn btn-success" ><?=$this->Dictionary->GetKeyword('Update')?></button>
            </div>
            
        </form>
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
	if (username && password.toLowerCase().match(username.toLowerCase()))
	return rating(0, "similar to username");
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
$("input[data-bootstrap-switch]").bootstrapSwitch('state');
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
			var rating = passwordRating(password, username.val());

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
            $('#EditProfileUser').validate({
        ignore: "",
        rules: {
            PASSWORD : {
                        minlength : 6,
                        check_password: "#NAME"
                        //required: true
                    },
            PASSWORD_CONFIRM : {
                        minlength : 6,
                        equalTo : '[name="PASSWORD"]'
                    }
        },
        highlight: function(element) {
            $(element).parent('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).parent('.form-group').removeClass('has-error');
            $(element).parent('.form-group').addClass('has-success');
        },
        success: function(element) {
            $(element).parent('.form-group').removeClass('has-error');
        },
        errorPlacement: function(error, element) {
            $(element).closest('.form-group').find('small').html(error.html());
        }
    });
            $('.select2').select2({ theme: 'bootstrap4'});
            $("[data-mask]").inputmask();
                $('#EditProfileUser').submit(function() {
                    if ($('#EditProfileUser').valid()) {
                             $.ajax({
                                type: "POST",
                                url: "<?=base_url('User/AjaxUpdateProfile/'.$this->UserModel->user_id());?>",
                                data: $('#EditProfileUser').serialize(),
                                success: function(response) {
                                    response=JSON.parse(response);
                                    if(response.status=='success'){
                                    $("#extra-modal").modal('hide');
                                    $('.modal-backdrop').remove(); 
                                    $("body").removeClass("modal-open");
                                    toastr.success(response.message);
                                    }else{
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