<?php echo $header; ?>
<style type="text/css">

	#loginbycall-enter-lnk-default img { height: auto;}
	/*--FORMS--*/
	#loginbycall-user-form div.form-item-login,
	#loginbycall-user-form div.form-item-pass{
		display:none;
	}
	#wrapper-loginbycall-form-offer-place {
		position: fixed;
		height: 100%;
		width: 100%;
		background: rgba(0,0,0,0.7);
		z-index: 1000;
		top: 0;
		left: 0;
		line-height: 1.5;
	}

	#loginbycall-form-offer-place {
		width: 400px;
		position: relative;
		background-color: white;
		text-align: center;
		z-index: 10000;
		margin: -70px auto 0 auto;
		border-color: gray;
		border-width: 1px;
		border-style: solid;
		box-shadow: 0 0 5px 2px gray;
		height: 140px;
		top: 50%;
	}
	#loginbycall-form-offer-place p{
		margin-left: 65px;
		font-family: Georgia, "Times New Roman", Times, serif;
		font-size: 14px;
		color: #707070;
		margin:0px;
		margin-top: 20px;
		margin-left: 45px;
		width: 300px;
		display: block;
		margin-bottom: 10px;
		height: 60px;
	}
	#loginbycall-form-close,
	#loginbycall-oauth-unbind,
	#yes-loginbycall{
		display: block;
		background: #89c450;
		width: 60px;
		height: 30px;
		padding-top: 5px;
		float: left;
		margin-left: 35px;
		color: white;
		border-radius: 5px;
		font-size: 13px;
		font-family: Georgia, "Times New Roman", Times, serif;
		text-decoration: none;
		box-sizing: border-box;
		/*	padding-bottom: 5px;*/
	}
	#loginbycall-form-offer-place a:hover{
		text-decoration: none;
	}
	#loginbycall-form-close{
		width: 90px;
		margin-left: 5px;
	}
	#loginbycall-oauth-unbind{
		width: 165px;
		margin-left: 5px;
		background: #B22222;
	}
	#loginbycall-close{
		width: 13px;
		background-image: url(../img/close-icon.png);
		height: 12px;
		display: block;
		position: absolute;
		top: 20px;
		right: 20px;
		cursor: pointer;
	}
	#loginbycall-wrapper{
		padding-bottom: 60px; 
	}
	div.loginbycall-oauth-unbind-value { display:none; }
	.form-item label{
		width: 150px;
		display: inline-block;

	}
	.form-item{
		margin-bottom: 10px;
	}
	.description{
		font-size: 12px;
	}
	.loginbycall-message{
		color: green;
	} 
	#loginbycall-enter-lnk-default {
		position: relative;
		display: block;
	}
	#loginbycall-enter-lnk-default img {
		height: 24px;
	}
	#loginbycall-enter-lnk-default span{
		font-size: 14px;
		text-decoration: none;
		color: #1E90FF;
		padding-bottom: 11px;
		display: block;
		position: absolute;
		top: 3px;
		left: 20px; 
	}
	label{
		font-weight: bold;
	}
	.form-text{
		display:block;
	}
</style>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<form action="/index.php?route=account/loginbycallbindform" method="post" id="loginbycall-user-form" accept-charset="UTF-8">
	<div>
		<div class="form-item form-type-radios form-item-create">
			<label for="edit-create"><?php echo $build_account; ?></label>
			<div id="edit-create" class="form-radios">
				<div class="form-item form-type-radio form-item-create">
					<input type="radio" id="edit-create-0" name="create" value="0" checked="checked" class="form-radio">
					<label class="option" for="edit-create-0"><?php echo $create_new_account; ?></label>
				</div>
				<div class="form-item form-type-radio form-item-create">
					<input type="radio" id="edit-create-1" name="create" value="1" class="form-radio">  <label class="option" for="edit-create-1"><?php echo $bind_account; ?></label>
				</div>
			</div>
		</div>
		<div class="form-item form-type-textfield form-item-create-login" style="display: block;">
			<label for="edit-create-login"><?php echo $enter_new_first_name; ?></label>
			<input type="text" id="edit-create-login" name="create_login" value="" size="60" maxlength="128" class="form-text">
			<div class="description"><?php echo $enter_new_first_name_description; ?></div>
		</div>
		<div class="form-item form-type-textfield form-item-create-email" style="display: block;">
			<label for="edit-create-email"><?php echo $enter_email; ?></label>
			<input type="text" id="edit-create-email" name="create_email" style="width: 300px; background: gainsboro;" value="<?php echo (isset($create_new_account_mail)? $create_new_account_mail : ''); ?>" size="60" maxlength="128" class="form-text">
			<div class="description"><?php echo $enter_email_description; ?></div>
		</div>
		<div class = "form-item form-type-textfield form-item-login" style = "display: none;">
			<label for = "edit-login"><?php echo $enter_email; ?></label>
			<input type = "text" id = "edit-login" name = "email" value = "" size = "60" maxlength = "128" class = "form-text">
			<div class = "description"><?php echo $enter_email_description; ?></div>
		</div>
		<div class = "form-item form-type-password form-item-pass" style = "display: none;">
			<label for = "edit-pass"><?php echo $password; ?></label>
			<input type = "password" id = "edit-pass" name = "password" size = "60" maxlength = "128" class = "form-text">
			<div class = "description"><?php echo $password_description; ?></div>
		</div>
		<input type = "submit" id = "loginbycall-edit-submit" name = "op" value = "Submit" class = "form-submit"><input type = "hidden" name = "form_build_id" value = "form_oauth_user">
		<input type = "hidden" name = "form_id" value = "loginbycall_user_form">
	</div>
</form>
<script type = "text/javascript"> 
	jQuery(document).ready(function(){
	window.setTimeout(loginbycallHiddenMessge, 1000);
	function loginbycallHiddenMessge(){
	jQery('.loginbycall-message').hiden();
}
if(jQuery('#loginbycall-user-form [name=create]:checked').val()==0){
jQuery('#loginbycall-user-form div.form-item-login, #loginbycall-user-form div.form-item-pass').hide();
jQuery('#loginbycall-user-form div.form-item-create-login').show();
jQuery('#loginbycall-user-form div.form-item-create-email').show();
}
if(jQuery('#loginbycall-user-form [name=create]:checked').val()==1){
jQuery('#loginbycall-user-form div.form-item-login, #loginbycall-user-form div.form-item-pass').show();
jQuery('#loginbycall-user-form div.form-item-create-login').hide();
jQuery('#loginbycall-user-form div.form-item-create-email').hide();
} 
	
jQuery('#loginbycall-user-form [name=create]').change(function(){
if(jQuery(this).val()==0){
jQuery('#loginbycall-user-form div.form-item-login, #loginbycall-user-form div.form-item-pass').hide();
jQuery('#loginbycall-user-form div.form-item-create-login').show();
jQuery('#loginbycall-user-form div.form-item-create-email').show();
} 
if(jQuery(this).val()==1){
jQuery('#loginbycall-user-form div.form-item-login, #loginbycall-user-form div.form-item-pass').show(); 
jQuery('#loginbycall-user-form div.form-item-create-login').hide();
jQuery('#loginbycall-user-form div.form-item-create-email').hide();
} 
});
jQuery('#loginbycall-edit-submit').click(function(){
if(jQuery('#edit-create-0').attr('checked')=='checked'){
if(!jQuery('#edit-create-login').val()){
jQuery('#edit-create-login').css('border-color','red');
return false;
}
if(!jQuery('#edit-create-email').val() || !makeCheck(jQuery('#edit-create-email').val())){
jQuery('#edit-create-email').css('border-color','red');
return false;
}
}
if(jQuery('#edit-create-1').attr('checked')=='checked'){
if(!jQuery('#edit-login').val()){
jQuery('#edit-login').css('border-color','red');
return false;
}
if(!jQuery('#edit-pass').val()){
jQuery('#edit-pass').css('border-color','red');
return false;
}	
}
});
	
/* -- Form OFFER -- */
//jQuery('#loginbycall-form-place').fadeIn(2000);
	
jQuery('#loginbycall-form-close').click(function(){
jQuery('#wrapper-loginbycall-form-offer-place').fadeOut(1000);
return false;
});
jQuery('#loginbycall-close').click(function(){
jQuery('#wrapper-loginbycall-form-offer-place').fadeOut(1000);
return false;
});
	
jQuery('#loginbycall-oauth-unbind').click(function(){
jQuery.post('/loginbycall-redirect-uri',{
unbind:jQuery('div.loginbycall-oauth-unbind-value').html()
});
jQuery('#wrapper-loginbycall-form-offer-place').fadeOut(1000);
return false;
});
function makeCheck(email)
	{

var re = /^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,6}$/i;
return re.test(email);
}
});
</script>
<!--<script type = "text/javascript" src = "' . plugins_url('loginbycall.js', __FILE__) . '" >  </script>
<link href = "' . plugins_url('css/loginbycall.css', __FILE__) . '" rel = "stylesheet" type = "text/css" />-->
<?php echo $footer; ?>