<style>
	div.loginbycall-oauth-unbind-value { display:none; }
	.form-item label{
		display: block;
		font-weight:bold;
	}

	.form-item label.label{
		display: inline;
	}
	.form-item{
		margin-bottom: 10px;
	}
	.description{
		font-size: 10px;
	}
	.loginbycall-message{
		color: green;
	} 
	#edit-submit{
		display: block;
		background: #89c450;
		width: 60px;
		height: 30px;
		padding-top: 5px;
		color: white;
		border-radius: 5px;
		font-size: 13px;
		font-family: Georgia, "Times New Roman", Times, serif;
		text-decoration: none;
		box-sizing: border-box;
		/*	padding-bottom: 5px;*/
	}
</style>
<?php echo $header; ?>
<div class="box">
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box-heading">LoginByCall Settings</div>
	<div class="box-content">
		<form action="<?php echo $action;?>" method="post" id="loginbycall-user-edit-form" accept-charset="UTF-8">
			<div>
				<input type="hidden" name="user_uid" value="1">
				<div class="form-item form-type-textfield form-item-set-name">
					<label for="edit-set-name"><?php echo $user_name; ?></label>
					<input type="text" id="edit-set-name" name="set_name" value="<?php echo $user_name_value; ?>" size="60" maxlength="128" class="form-text">
				</div>
				<div class="form-item form-type-textfield form-item-user-mail form-disabled">
					<label for="edit-user-mail"><?php echo $user_mail; ?></label>
					<input disabled="disabled" type="text" id="edit-user-mail" name="user_mail" value="<?php echo $user_mail_value; ?>" size="60" maxlength="128" class="form-text">
				</div>
				<?php if ($loginbycall_resolution) { ?>
				<div class="form-item form-type-checkbox form-item-user-unbind">
					<input type="checkbox" id="edit-user-unbind" name="user_unbind" value="1" class="form-checkbox">
					<label class="option label" for="edit-user-unbind"><?php echo $unbind; ?></label>
					<div class="description"><?php echo $unbind_account_loginbycall; ?></div>
				</div>
				<?php } ?>
				<div class="form-item">
					<input type="hidden" name="form_id" value="loginbycall_user_edit_form">
					<input type = "submit" id = "edit-submit" name = "loginbycall-user-edit-form" value = "<?php echo $submit; ?>" class = "form-submit">
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>