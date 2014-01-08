<?php

class ControllerAccountLoginbycallsettings extends Controller {

	private $error = array();

	public function index() {
		$this->language->load('module/loginbycallsettings');
		$this->data['error_warning'] = null;
		$this->load->model('account/customer');
		//$this->load->model('tool/loginbycallfunction');
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate_login()) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->request->post['set_name'] . "' WHERE customer_id = '" . $this->customer->getId() . "'");
		}
		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');
			$customer_info = $this->model_account_customer->getCustomer((int) $this->customer->getId());
			$this->data['user_name_value'] = $customer_info['firstname'];
			$query = $this->db->query("SELECT mail FROM " . DB_PREFIX . "loginbycall_user lu WHERE lu.uid = '" . $this->customer->getId() . "'");
			if ($query->num_rows) {
				if (isset($_POST['user_unbind'])) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "loginbycall_user WHERE uid = '" . $this->customer->getId() . "'");
					$this->redirect($this->url->link('account/account', '', 'SSL'));
				}
				$this->data['user_mail_value'] = $query->rows[0]['mail'];
			} else {
				$this->redirect($this->url->link('account/account', '', 'SSL'));
			}
		} else {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}
		$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
//		echo '<pre>';
//		print_r($setting_loginbycall);
//		echo '</pre>';
		$this->data['user_name'] = $this->language->get('user_name');
		$this->data['user_mail'] = $this->language->get('user_mail');
		$this->data['submit'] = $this->language->get('submit');
		$this->data['unbind'] = $this->language->get('unbind');

		$this->data['unbind_account_loginbycall'] = $this->language->get('unbind_account_loginbycall');
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