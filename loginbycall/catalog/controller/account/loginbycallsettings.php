<?php

class ControllerAccountLoginbycallsettings extends Controller {

	private $error = array();

	public function index() {
		$this->language->load('module/loginbycallsettings');
		$this->data['error_warning'] = FALSE;
		$this->data['hidden_settings_form'] = FALSE;
		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');
			$this->load->model('setting/setting');

			$customer_info = $this->model_account_customer->getCustomer((int) $this->customer->getId());

			$query = $this->db->query("SELECT mail FROM " . DB_PREFIX . "loginbycall_user lu WHERE lu.uid = '" . $this->customer->getId() . "'");
			if (!$query->num_rows) {
				$this->data['hidden_settings_form'] = TRUE;
			}
			$query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "loginbycall_status ls WHERE ls.uid = " . $this->customer->getId());
			if ($query->num_rows) {
				$this->data['hidden_settings_form'] = TRUE;
			}
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->data['hidden_settings_form'] && isset($this->request->post['user_bind'])) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "loginbycall_status WHERE uid = '" . $this->customer->getId() . "'");
				$this->load->model('tool/loginbycallfunction');
				//die('123');
				$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
				$link = $this->model_tool_loginbycallfunction->loginbycall_create_link($setting_loginbycall['id_application'], $setting_loginbycall['adress_callback'], $customer_info['firstname']);
				$this->redirect($link);
				//$this->db->query("INSERT INTO " . DB_PREFIX . "loginbycall_user SET uid = " . $this->customer->session->data['customer_id'] . ", login = '" . $customer_info['firstname'] . "' , mail ='" . $customer_info['email'] . "', target_token='" . $obj->target_token . "',status=1");
			}

			//$this->load->model('tool/loginbycallfunction');
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->data['hidden_settings_form'] && isset($this->request->post['set_name']) && $this->validate_login()) {
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->request->post['set_name'] . "' WHERE customer_id = '" . $this->customer->getId() . "'");
			}

			$this->data['user_name_value'] = $customer_info['firstname'];
			$query = $this->db->query("SELECT mail FROM " . DB_PREFIX . "loginbycall_user lu WHERE lu.uid = '" . $this->customer->getId() . "'");
			if ($query->num_rows) {
				if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['user_unbind'])) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "loginbycall_user WHERE uid = '" . $this->customer->getId() . "'");
				}
				$this->data['user_mail_value'] = $query->rows[0]['mail'];
			}
		} else {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}
		$query = $this->db->query("SELECT mail FROM " . DB_PREFIX . "loginbycall_user lu WHERE lu.uid = '" . $this->customer->getId() . "'");
		if (!$query->num_rows) {
			$this->data['hidden_settings_form'] = TRUE;
		}
		$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
		$this->data['user_name'] = $this->language->get('user_name');
		$this->data['user_mail'] = $this->language->get('user_mail');
		$this->data['submit'] = $this->language->get('submit');
		$this->data['unbind'] = $this->language->get('unbind');
		$this->data['unbind_account_loginbycall'] = $this->language->get('unbind_account_loginbycall');
		$this->data['bind'] = $this->language->get('bind');
		$this->data['bind_account_loginbycall'] = $this->language->get('bind_account_loginbycall');
		$this->data['action'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$this->data['loginbycall_resolution'] = $setting_loginbycall['resolution'];

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/loginbycallsettings.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/loginbycallsettings.tpl';
		} else {
			$this->template = 'default/template/module/loginbycallsettings.tpl';
		}
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
		$this->response->setOutput($this->render());
		//die('1231');
	}

	public function validate_login() {
		if ((utf8_strlen($this->request->post['set_name']) < 1) || (utf8_strlen($this->request->post['set_name']) > 32)) {
			$this->data['error_warning'] = $this->language->get('error_firstname');
			return false;
		}
		return true;
	}

}

?>