<?php

class ControllerAccountLoginbycallredirect extends Controller {

	private $error = array();

	public function index() {
		$this->load->model('setting/setting');
		$this->load->model('tool/loginbycallfunction');
		$this->load->model('account/customer');
		$setting_loginbycall = $this->model_setting_setting->getSetting('loginbycall', 0);
		$obj = $this->model_tool_loginbycallfunction->loginbycall_oauth_render($setting_loginbycall['adress_callback'], $setting_loginbycall['id_application'], $setting_loginbycall['secret_key'], $setting_loginbycall['authorization_code'], null);
		if (isset($this->customer->session->data['customer_id'])) {
			if (strpos($_SERVER['REQUEST_URI'], 'code=')) {
				$code = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], 'code=') + 5);
				$customer_info = $this->model_account_customer->getCustomer($this->customer->session->data['customer_id']);
				$obj = $this->model_tool_loginbycallfunction->loginbycall_oauth_render($setting_loginbycall['adress_callback'], $setting_loginbycall['id_application'], $setting_loginbycall['secret_key'], $setting_loginbycall['authorization_code'], $code);
				$query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "loginbycall_user lu WHERE lu.target_token = '" . $obj->target_token . "'");
				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "loginbycall_user SET uid = " . $this->customer->session->data['customer_id'] . ", login = '" . $this->customer->getFirstName() . "' , mail ='" . $customer_info['email'] . "', target_token='" . $obj->target_token . "',status=1");
				}
				$this->redirect($this->url->link('account/loginbycallsettings', '', 'SSL'));
			} else {
				$this->redirect($this->url->link('account/account', '', 'SSL'));
			}
		} else {
			if (strpos($_SERVER['REQUEST_URI'], 'code=')) {
				$this->session->data['code'] = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], 'code=') + 5);
				$this->session->data['request_obj'] = $this->model_tool_loginbycallfunction->loginbycall_oauth_render($setting_loginbycall['adress_callback'], $setting_loginbycall['id_application'], $setting_loginbycall['secret_key'], $setting_loginbycall['authorization_code'], $this->session->data['code']);
				$query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "loginbycall_user lu WHERE lu.target_token = '" . $this->session->data['request_obj']->target_token . "'");
				if ($query->num_rows) {
					$mail = $query->rows[0]['uid'];
					$query = $this->db->query("SELECT email FROM " . DB_PREFIX . "customer cu WHERE cu.customer_id = '" . $query->rows[0]['uid'] . "'");
					$mail = $query->rows[0]['email'];
					$customer_info = $this->model_account_customer->getCustomerByEmail($mail);
					$this->session->data['customer_id'] = $customer_info['customer_id'];
					$this->redirect($this->url->link('account/loginbycallsettings', '', 'SSL'));
				} else {
					$this->redirect($this->url->link('account/loginbycallbindform', '', 'SSL'));
				}
			} else {
				$this->redirect($this->url->link('account/account', '', 'SSL'));
			}
		}
	}

	private function validate() {

		return true;
	}

}

?>