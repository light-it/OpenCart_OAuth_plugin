<?php

class ControllerModuleLoginbycall extends Controller {

	private $error = array();

	public function index() {
		//$this->load->model('loginbycall/function');
		$this->language->load('module/loginbycall');
		$this->load->model('tool/loginbycallfunction');
		$this->load->model('setting/setting');
		$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_my_orders'] = $this->language->get('text_my_orders');
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_account_create'] = $this->language->get('text_account_create');
		$this->data['text_forgotten'] = $this->language->get('text_forgotten');
		$this->data['text_my_account'] = $this->language->get('text_my_account');
		$this->data['text_history'] = $this->language->get('text_history');
		$this->data['text_welcome'] = $this->language->get('text_welcome');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['sign_in_sign_up'] = $this->language->get('sign_in_sign_up');
		$this->data['text_loginbycall_settings'] = $this->language->get('text_loginbycall_settings');
		$this->data['loginbycall_settings'] = $this->url->link('account/loginbycallsettings', '', 'SSL');

		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_password'] = $this->language->get('entry_password');

		$this->data['button_login'] = $this->language->get('button_login');
		$this->data['button_logout'] = $this->language->get('button_logout');

		$this->data['information'] = $this->url->link('account/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');

		$this->data['history'] = $this->url->link('account/order', '', 'SSL');
		$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$this->data['account_create'] = $this->url->link('account/register', '', 'SSL');
		$this->data['my_account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
		$this->data['logout'] = $this->url->link('account/logout', '', 'SSL');

		$this->id = 'loginbycall';

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			if (isset($this->request->post['email']) && isset($this->request->post['password']) && $this->validate()) {
				if (isset($this->request->post['redirect'])) {
					$this->redirect($this->request->post['redirect']);
				} else {
					$this->redirect(HTTPS_SERVER);
				}
			}
		}

		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');
			$customer_info = $this->model_account_customer->getCustomer((int) $this->customer->getId());
			$this->data['firstname'] = $customer_info['firstname'];
			$this->data['logged'] = true;
		} else {
			$this->data['logged'] = false;
		}


		if (isset($this->error['message'])) {
			$this->data['error'] = $this->error['message'];
		} else {
			$this->data['error'] = '';
		}
		$this->data['action'] = $this->url->link('account/loginbycall', '', 'SSL');
		$this->data['action_loginbycall'] = $this->model_tool_loginbycallfunction->loginbycall_create_link($setting_loginbycall['id_application'], $setting_loginbycall['adress_callback']);
		if (isset($this->request->post['redirect'])) {
			//echo $this->request->post['redirect'];
			//die('79');
			$this->data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			//echo $this->session->data['redirect'];
			//die('82');
			$this->data['redirect'] = $this->session->data['redirect'];
			unset($this->session->data['redirect']);
		} else {
			//echo 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			//die('86');
			$this->data['redirect'] = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['account'])) {
			$this->data['account'] = $this->session->data['account'];
		} else {
			$this->data['account'] = 'register';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/loginbycall.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/loginbycall.tpl';
		} else {
			$this->template = 'default/template/module/loginbycall.tpl';
		}

		$this->render();
	}

	private function validate() {
		if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
			$this->error['message'] = $this->language->get('error_login');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}

?>