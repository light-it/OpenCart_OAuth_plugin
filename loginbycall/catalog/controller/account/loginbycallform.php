<?php

class ControllerAccountLoginbycallform extends Controller {

	private $error = array();

	public function index() {
		$this->load->model('account/customer');
		$this->load->model('tool/loginbycallfunction');
		$this->load->model('setting/setting');
		//если пользователь установил , больше не предлагать то сразу перекидываем его на страницу его аккаунта.
		if ($this->customer->getId()) {
			$query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "loginbycall_status ls WHERE ls.uid = " . $this->customer->getId());
			if ($query->num_rows) {
				$this->redirect($this->url->link('account/account', '', 'SSL')); 
			}
		}
		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');
			$customer_info = $this->model_account_customer->getCustomer((int) $this->customer->getId());
			$this->data['firstname'] = $customer_info['firstname'];
			$this->data['logged'] = true;
			$query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "loginbycall_user lu WHERE lu.uid = '" . $this->customer->getId() . "'");
			if ($query->num_rows) {
				$this->redirect($this->url->link('account/account', '', 'SSL'));
			}
		} else {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}
		$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
//		echo '<pre>';
//		print_r($setting_loginbycall);
//		echo '</pre>';
		$this->language->load('module/loginbycallform');
		$this->document->addScript('catalog/view/javascript/loginbycallform.js');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
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
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/loginbycallform.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/loginbycallform.tpl';
		} else {
			$this->template = 'default/template/module/loginbycallform.tpl';
		}

		$this->data['message'] = $this->language->get('message');
		$this->data['on_site'] = $this->language->get('on_site');
		$this->data['yes'] = $this->language->get('yes');
		$this->data['not_now'] = $this->language->get('not_now');
		$this->data['no_longer_offer'] = $this->language->get('no_longer_offer');
		$this->data['not_now_response'] = $this->url->link('account/account', '', 'SSL');
		$this->data['user_login'] = $this->customer->getEmail();
		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');
			$customer_info = $this->model_account_customer->getCustomer((int) $this->customer->getId());
			$this->data['yes_response'] = $this->model_tool_loginbycallfunction->loginbycall_create_link($setting_loginbycall['id_application'], $setting_loginbycall['adress_callback'], $customer_info['email']);
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
	}

}

?>