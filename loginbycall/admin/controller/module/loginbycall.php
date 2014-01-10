<?php

//контроллер админки 
class ControllerModuleLoginbycall extends Controller {

	private $error = array();

	private function install() {
		
	}

	public function index() {
		$this->load->language('module/loginbycall');
		$this->load->model('setting/setting');
		$this->document->setTitle($this->language->get('heading_title'));
		//$this->model_setting_setting->editSetting('loginbycall', 'loginbycall');	
		//$this->document->title = $this->language->get('heading_title');
		//$this->response->setOutput($this->render());
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/loginbycall', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "logimbycall_user (
			id4 int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			uid int(11) DEFAULT NULL COMMENT 'UID drupal user',
			login varchar(100) DEFAULT NULL COMMENT 'loginbycall user login',
			mail varchar(100) DEFAULT NULL COMMENT 'loginbycall user email',
			target_token varchar(255) DEFAULT NULL COMMENT 'loginbycall target_token',
			status int(11) DEFAULT NULL COMMENT 'Bind status',
			PRIMARY KEY (id4)
			) ENGINE = InnoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1;");
			$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "loginbycall_status (
			uid int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			status int(11) DEFAULT NULL COMMENT 'UID drupal user',
			PRIMARY KEY (uid)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$this->data['base'] = str_replace('admin/', "", HTTPS_SERVER);
			} else {
				$this->data['base'] = str_replace('admin/', "", HTTP_SERVER);
			}
			$this->request->post['adress_callback'] = $this->data['base'] . 'loginbycallredirect';

			$this->request->post['authorization_code'] = 'authorization_code';
			if (isset($this->request->post['sending_mail'])) {
				$this->request->post['sending_mail'] = 1;
			} else {
				$this->request->post['sending_mail'] = 0;
			}
			if (isset($this->request->post['resolution'])) {
				$this->request->post['resolution'] = 1;
			} else {
				$this->request->post['resolution'] = 0;
			}
			$this->model_setting_setting->editSetting('loginbycall', $this->request->post);
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
//		echo '<pre>';
//		print_r(    $setting_loginbycall);
//		echo '</pre>';

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['button_save'] = $this->language->get('button_save');

		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (!isset($setting_loginbycall['adress_callback'])) {
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$this->data['base'] = str_replace('admin/', "", HTTPS_SERVER);
			} else {
				$this->data['base'] = str_replace('admin/', "", HTTP_SERVER);
			}
			$this->request->post['adress_callback'] = $this->data['base'] . 'loginbycallredirect';
			$this->model_setting_setting->editSetting('loginbycall', $this->request->post);
		}
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = str_replace('admin/', "", HTTPS_SERVER);
		} else {
			$this->data['base'] = str_replace('admin/', "", HTTP_SERVER);
		}
		$this->data['adress_callback'] = $this->language->get('adress_callback');
		$this->data['adress_callback_value'] = $this->data['base'] . 'loginbycallredirect';
		$this->data['adress_callback_description'] = $this->language->get('adress_callback_description');

		$this->data['id_application'] = $this->language->get('ID application');
		if (isset($setting_loginbycall['id_application'])) {
			$this->data['id_application_value'] = $setting_loginbycall['id_application'];
		} else {
			$this->data['id_application_value'] = '';
		}
		$this->data['id_application_description'] = $this->language->get('Enter your application ID');

		$this->data['secret_key'] = $this->language->get('secret_key');
		if (isset($setting_loginbycall['secret_key'])) {
			$this->data['secret_key_value'] = $setting_loginbycall['secret_key'];
		} else {
			$this->data['secret_key_value'] = '';
		}

		$this->data['secret_key_description'] = $this->language->get('secret_key_description');

		$this->data['authorization_code'] = $this->language->get('authorization_code');
		if (isset($setting_loginbycall['authorization_code'])) {
			$this->data['authorization_code_value'] = $setting_loginbycall['authorization_code'];
		} else {
			$this->data['authorization_code_value'] = 'authorization_code';
		}
		$this->data['authorization_code_description'] = $this->language->get('authorization_code_description');

		$this->data['password_length'] = $this->language->get('password_length');
		if (isset($setting_loginbycall['password_length']) && $setting_loginbycall['password_length'] != '') {
			$this->data['password_length_value'] = $setting_loginbycall['password_length'];
		} else {
			$this->data['password_length_value'] = 12;
		}
		$this->data['password_length_description'] = $this->language->get('password_length_description');

		$this->data['sending_mail'] = $this->language->get('sending_mail');
		if (isset($setting_loginbycall['sending_mail'])) {
			$this->data['sending_mail_value'] = $setting_loginbycall['sending_mail'];
		} else {
			$this->data['sending_mail_value'] = '';
		}
		$this->data['sending_mail_description'] = $this->language->get('sending_mail_description');

		$this->data['resolution'] = $this->language->get('resolution');
		if (isset($setting_loginbycall['resolution'])) {
			$this->data['resolution_value'] = $setting_loginbycall['resolution'];
		} else {
			$this->data['resolution_value'] = '';
		}
		$this->data['resolution_description'] = $this->language->get('resolution_description');

		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['settings'] = $this->language->get('settings');

		$this->data['position'] = $this->language->get('position');

		$this->data['action'] = $this->url->link('module/loginbycall', 'token=' . $this->session->data['token'], 'SSL');




		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->data['button_add_module'] = $this->language->get('button_add_module');

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();


		$this->data['modules'] = array();

		if (isset($this->request->post['loginbycall_module'])) {
			$this->data['modules'] = $this->request->post['loginbycall_module'];
		} elseif ($this->config->get('loginbycall_module')) {
			$this->data['modules'] = $this->config->get('loginbycall_module');
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		$this->template = 'module/loginbycall.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->error
		) {
			return true;
		} else {
			return false;
		}
	}

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
