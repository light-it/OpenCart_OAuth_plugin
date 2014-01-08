/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function () {
	jQuery("#yes-loginbycall").click(function(){
		jQuery("#response").val('yes');
//		jQuery("#loginbycallform").submit();
	});
//	jQuery("#loginbycall-form-close").click(function(){
//		jQuery("#response").val('not_now');
//		jQuery("#loginbycallform").submit();
//		return false;
//	});
	jQuery("#loginbycall-oauth-unbind").click(function(){
		jQuery("#response").val('no_longer_offer');
		jQuery("#loginbycallform").submit();
		return false;
	});
});
