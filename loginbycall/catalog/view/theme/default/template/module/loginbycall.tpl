<style type="text/css">
	#loginbycall_fast span:hover{
		text-decoration: none;
	}
	#loginbycall_fast span{
		font-size: 14px;
		color: #38B0E3;
		padding-bottom: 11px;
		text-decoration: underline;
	}
	#loginbycall_fast .separator{
		color:black;
		text-decoration: none;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
	$('#password').bind('keypress', function(e) {
	var code = (e.keyCode ? e.keyCode : e.which);
	if(code==13){
	$('#login_module').submit();
}
});
});
	
</script>
<div class="box">
	<div class="box-heading"><?php echo $fast_authorization; ?></div>
	<div id="loginbycall_fast" class="box-content">
		<a href="<? echo $action_loginbycall; ?>" style="display: block; width: 200px;text-decoration: none; color: black;" class="loginbycall">
			<div style="float: left;margin-top: -2px;"><img src="http://loginbycall.com/assets/logo.jpg" width="24px" height="24px" style="" alt="Войти через loginbycall"/></div>
			<div style="margin-left: 35px;">
				<span><?php echo $login; ?></span>
				<span class="separator"> / </span>
				<span><?php echo $register; ?></span>
			</div>
		</a>
	</div>
	<br/>
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div id="loginbycall" class="box-content">
		<?php if (!$logged) { ?>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="login_module">
			<b><?php echo $entry_email; ?>:</b><br />
			<input type="text" name="email" />
			<br />
			<br />
			<b><?php echo $entry_password; ?>:</b><br />
			<input type="password" name="password" id="password" onkeypress=" alert(e.keyCode);" />
			<br />
			<a href="<?php echo $account_create; ?>"><?php echo $text_account_create; ?></a>
			<br />
			<a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
			<div style="margin-top: 10px;"><a onclick="$('#login_module').submit();" class="button"><span><?php echo $button_login; ?></span></a></div>
			<?php if ($redirect) { ?>
			<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
			<?php } ?>
		</form>

		<?php } else { ?>
		<p>
			<b><?php echo $text_my_account; ?></b>
		<ul>
			<li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>
			<li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
			<li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
		</ul>
		</p>
		<p>
			<b><?php echo $text_my_orders; ?></b>
		<ul>
			<li><a href="<?php echo $history; ?>"><?php echo $text_history; ?></a></li>
		</ul>
		</p>
		<p>
			<b><?php echo $text_loginbycall_settings; ?></b>
		<ul>
			<li><a href="<?php echo $loginbycall_settings; ?>"><?php echo $text_loginbycall_settings; ?></a></li>
		</ul>
		</p>
		<div style="margin: 12px 0 12px 40px; text-align: left;"><a href="<?php echo $logout; ?>" class="button"><span><?php echo $button_logout; ?></span></a></div>
		<? } ?>
	</div>
</div>