<?php

class ControllerAccountLoginbycallbindform extends Controller {

	private $error = array();

	public function index() {
		$this->data['error_warning'] = NULL;
		$this->load->model('account/customer');
		$this->load->model('tool/loginbycallfunction');
		$this->load->model('setting/setting');
		$this->language->load('module/loginbycallbindform');
		$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
		$obj = $this->session->data['request_obj'];
		if (!isset($obj)) {
			$this->redirect($this->url->link('account/loginbycallsettings', '', 'SSL'));
		}
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ($this->request->post['create'] == '1') {
				if ($this->validate_bind_account()) {
					$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
					$this->session->data['customer_id'] = $customer_info['customer_id'];
					$query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "loginbycall_status ls WHERE ls.uid = " . $customer_info['customer_id']);
					if ($query->num_rows) {
						$this->db->query("DELETE FROM " . DB_PREFIX . "loginbycall_status WHERE uid = '" . $customer_info['customer_id'] . "'");
					}
					$this->db->query("INSERT INTO " . DB_PREFIX . "loginbycall_user SET uid = " . $this->customer->session->data['customer_id'] . ", login = '" . $customer_info['firstname'] . "' , mail ='" . $obj->email . "', target_token='" . $obj->target_token . "',status=1");
					$this->redirect($this->url->link('account/loginbycallsettings', '', 'SSL'));
				}
			} else {
				if ($this->validate_create_account()) {
					$pass = $this->model_tool_loginbycallfunction->password_generator($setting_loginbycall['password_length']);
					$data['firstname'] = $this->request->post['create_login'];
					$data['lastname'] = 'empty';
					$data['email'] = $this->request->post['create_email'];
					$data['telephone'] = '000-000';
					$data['fax'] = '';
					$data['company'];
					$data['customer_group_id'] = '1';
					$data['company_id'] = '';
					$data['tax_id'] = '';
					$data['address_1'] = 'empty';
					$data['address_2'] = '';
					$data['city'] = 'empty';
					$data['postcode'] = '000';
					$data['country_id'] = '222';
					$data['zone_id'] = '3513';
					$data['password'] = $pass;
					$data['confirm'] = $pass;
					$data['newsletter'] = '1';
					$data['agree'] = 1;
					$this->model_account_customer->addCustomer($data);
					$this->customer->login($data['email'], $data['password']);
					$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['create_email']);
					$this->db->query("INSERT INTO " . DB_PREFIX . "loginbycall_user SET uid = " . $this->customer->session->data['customer_id'] . ", login = '" . $customer_info['firstname'] . "' , mail ='" . $this->request->post['create_email'] . "', target_token='" . $obj->target_token . "',status=1");
					$this->redirect($this->url->link('account/loginbycallsettings', '', 'SSL'));
				}
			}
		}
		$this->document->addScript('catalog/view/javascript/loginbycallform.js');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['response'])) {
			if ($this->request->post['response'] == 'no_longer_offer') {
				$query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "loginbycall_status ls WHERE ls.uid = " . $this->customer->getId());
				//устнавливаем статус в 3 - значит пользователь нажал больше не предлагать 
				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "loginbycall_status SET uid = " . $this->customer->getId() . ", status = 3");
					$this->redirect($this->url->link('account/account', '', 'SSL'));
				}
			}
			//$this->redirect($this->url->link('account/account', '', 'SSL'));
		} else {
			$this->data['action'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/loginbycallbindform.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/loginbycallbindform.tpl';
		} else {
			$this->template = 'default/template/module/loginbycallbindform.tpl';
		}

		$this->data['build_account'] = $this->language->get('build_account');
		$this->data['create_new_account'] = $this->language->get('create_new_account');
		$this->data['bind_account'] = $this->language->get('bind_account');
		$this->data['enter_new_login'] = $this->language->get('enter_new_login');
		$this->data['enter_new_login_description'] = $this->language->get('enter_new_login_description');
		$this->data['enter_email'] = $this->language->get('enter_email');
		$this->data['enter_email_description'] = $this->language->get('enter_email_description');
		$this->data['password'] = $this->language->get('password');
		$this->data['password_description'] = $this->language->get('password_description');
		$this->data['not_now_response'] = $this->url->link('account/account', '', 'SSL');

		$this->data['user_login'] = $this->customer->getEmail();
		$this->data['yes_response'] = $this->model_tool_loginbycallfunction->loginbycall_create_link($setting_loginbycall['id_application'], $setting_loginbycall['adress_callback']);
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
		$this->response->setOutput($this->render());
	}

	private function validate_bind_account() {
		if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
			$this->data['error_warning'] = $this->language->get('error_login');
			return false;
		}

		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['approved']) {
			$this->data['error_warning'] = $this->language->get('error_approved');
			return false;
		}
		return true;
	}

	private function validate_create_account() {
		if ((utf8_strlen($this->request->post['create_login']) < 1) || (utf8_strlen($this->request->post['create_login']) > 32)) {
			$this->data['error_warning'] = $this->language->get('create_login');
			return false;
		}

		if ((utf8_strlen($this->request->post['create_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['create_email'])) {
			$this->data['error_warning'] = $this->language->get('error_email');
			return false;
		}

		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['create_email'])) {
			$this->data['error_warning'] = $this->language->get('error_exists');
			return false;
		}
		return true;
	}

}

?>