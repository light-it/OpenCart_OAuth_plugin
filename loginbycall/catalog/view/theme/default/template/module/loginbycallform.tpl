<style>
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
		margin: auto;
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
	#loginbycall-wrapper{
		padding-bottom: 60px; 
	}
	div.loginbycall-oauth-unbind-value { display:none; }
	.form-item label{
		width: 300px;
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
</style>
<?php echo $header; ?>
<div class="box">

	<div class="box-heading"></div>
	<div class="box-content">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="loginbycallform">
			<input id="response" type="hidden" name="response" />
			<div id="loginbycall-form-offer-place">
				<p>
					<?php echo $message; ?> <?php echo '<b>' . $user_login . '</b>'; ?>
					<?php echo $on_site;?> <?php echo  '<b>' . $_SERVER['HTTP_HOST'] . '</b>'; ?> ?
				</p>
				<div id="loginbycall-wrapper">
					<a id="yes-loginbycall" href="<?php echo $yes_response; ?>"><?php echo $yes; ?></a>
					<a id="loginbycall-form-close" href="<?php echo $not_now_response; ?>"><?php echo $not_now; ?></a>
					<a id='loginbycall-oauth-unbind' href="#"><?php echo $no_longer_offer; ?></a>
					<div class="loginbycall-oauth-unbind-value"></div>
				</div>	
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>