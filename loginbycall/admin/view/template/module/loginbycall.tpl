<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
	<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading">
			<h1><img src="http://loginbycall.com/assets/logo.jpg" height="24px;" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
				<div class="vtabs" >
					<a href="#" onclick="$('#position').hide(); $('#settings').show(); return false;"><?php echo $settings; ?></a>
					<a href="#" onclick="$('#settings').hide(); $('#position').show(); return false;"><?php echo $position; ?></a>
				</div>

				<table id="settings" class="list" style="width: 89%;">
					<tr>
						<td><?php echo $adress_callback; ?></td>
						<td><input name="adress_callback" type="text" style="width: 300px; background: gainsboro;"  disabled="disabled"  value="<?php echo $adress_callback_value; ?>"/></td>
						<td><?php echo $adress_callback_description; ?></td>
					</tr>
					<tr>
						<td><?php echo $id_application; ?></td>
						<td><input name="id_application" type="text" style="width: 300px;" value="<?php echo $id_application_value; ?>"/></td>
						<td><?php echo $id_application_description; ?></td>
					</tr>
					<tr>
						<td><?php echo $secret_key; ?></td>
						<td><input name="secret_key" type="text" style="width: 300px;" value="<?php echo $secret_key_value; ?>"/></td>
						<td><?php echo $secret_key_description; ?></td>
					</tr>
					<tr>
						<td><?php echo $authorization_code; ?></td>
						<td><input name="authorization_code" type="text" disabled="disabled"  style="width: 300px; background: gainsboro;"  value="<?php echo $authorization_code_value; ?>"/></td>
						<td><?php echo $authorization_code_description; ?></td>
					</tr>
					<tr>
						<td><?php echo $password_length; ?></td>
						<td><input name="password_length" type="text" style="width: 300px;" value="<?php echo $password_length_value; ?>"/></td>
						<td><?php echo $password_length_description; ?></td>
					</tr>
					<tr>
						<td><?php echo $sending_mail; ?></td>
						<td><input type="checkbox" id="edit-mail" name="sending_mail" value="1" <?php echo (($sending_mail_value == 1) ? 'checked="checked"' : ''); ?> class="form-checkbox"></td>
						<td><?php echo $sending_mail_description; ?></td>
					</tr>
					<tr>
						<td><?php echo $resolution; ?></td>
						<td><input type="checkbox" id="edit-resolution" name="resolution" <?php echo (($resolution_value == 1) ? 'checked="checked"' : ''); ?> value="1" class="form-checkbox"></td>
						<td><?php echo $resolution_description; ?></td>
					</tr>

				</table>
				<table id="position" class="list" style="width: 89%; display: none;" >
					<thead>
						<tr>
							<td class="left"><?php echo $entry_layout; ?></td>
							<td class="left"><?php echo $entry_position; ?></td>
							<td class="left"><?php echo $entry_status; ?></td>
							<td class="right"><?php echo $entry_sort_order; ?></td>
							<td></td>
						</tr>
					</thead>
					<?php $module_row = 0; ?>
					<?php foreach ($modules as $module) { ?>
					<tbody id="module-row<?php echo $module_row; ?>">
						<tr>
							<td class="left"><select name="loginbycall_module[<?php echo $module_row; ?>][layout_id]">
									<?php foreach ($layouts as $layout) { ?>
									<?php if ($layout['layout_id'] == $module['layout_id']) { ?>
									<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
									<?php } else { ?>
									<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
									<?php } ?>
									<?php } ?>
								</select></td>
							<td class="left"><select name="loginbycall_module[<?php echo $module_row; ?>][position]">
									<?php if ($module['position'] == 'content_top') { ?>
									<option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
									<?php } else { ?>
									<option value="content_top"><?php echo $text_content_top; ?></option>
									<?php } ?>  
									<?php if ($module['position'] == 'content_bottom') { ?>
									<option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
									<?php } else { ?>
									<option value="content_bottom"><?php echo $text_content_bottom; ?></option>
									<?php } ?>    
									<?php if ($module['position'] == 'column_left') { ?>
									<option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
									<?php } else { ?>
									<option value="column_left"><?php echo $text_column_left; ?></option>
									<?php } ?>
									<?php if ($module['position'] == 'column_right') { ?>
									<option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
									<?php } else { ?>
									<option value="column_right"><?php echo $text_column_right; ?></option>
									<?php } ?>
								</select>
							</td>
							<td class="left"><select name="loginbycall_module[<?php echo $module_row; ?>][status]">
									<?php if ($module['status']) { ?>
									<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
									<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
									<option value="1"><?php echo $text_enabled; ?></option>
									<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select></td>
							<td class="right"><input type="text" name="loginbycall_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
							<td class="left"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
						</tr>
					</tbody>
					<?php $module_row++; ?>
					<?php } ?>
					<tfoot>
						<tr>
							<td colspan="4"></td>
							<td class="left"><a onclick="addModule();" class="button"><span><?php echo $button_add_module; ?></span></a></td>
						</tr>
					</tfoot>

				</table>

			</form>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	var module_row = <?php echo $module_row; ?>;

	function addModule() {	
	html  = '<tbody id="module-row' + module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><select name="loginbycall_module[' + module_row + '][layout_id]">';
		<?php foreach ($layouts as $layout) { ?>
		html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
		<?php } ?>
	html += '    </select></td>';
html += '    <td class="left"><select name="loginbycall_module[' + module_row + '][position]">';
html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
html += '    </select></td>';
html += '    <td class="left"><select name="loginbycall_module[' + module_row + '][status]">';
html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
html += '      <option value="0"><?php echo $text_disabled; ?></option>';
html += '    </select></td>';
html += '    <td class="right"><input type="text" name="loginbycall_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
html += '    <td class="left"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
html += '  </tr>';
html += '</tbody>';
	
$('#position tfoot').before(html);
	
module_row++;
}
//--></script>
<?php echo $footer; ?>