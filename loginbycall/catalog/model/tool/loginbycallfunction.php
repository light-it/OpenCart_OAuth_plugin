<?php

//модель каталога
class ModelToolLoginbycallfunction extends Model {

	public function test($a) {
		return $a;
	}

	public function loginbycall_oauth_render($redirect_uri, $client_id, $client_secret, $grant_type, $code, $target_token = NULL) {
		if (!$code) {
			$code = NULL;
		}
		/* Формируем POST запрос к серверу на получение acess_token */
		$context_access = stream_context_create(array(
			'http' => array('method' => 'POST',
				'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
				'content' => "code=$code&redirect_uri=$redirect_uri&client_id=$client_id&client_secret=$client_secret&grant_type=$grant_type"
				)));
//		echo '20<pre>';
//		print_r($context_access);
//		echo '</pre>';
		/* POST получение acess_token */
		$answer = json_decode(@file_get_contents("https://loginbycall.com/oauth/token", false, $context_access));
//		echo '25<pre>';
//		print_r($answer);
//		echo '</pre>';
		/* Обрабатываем ошибку получения access_token */
		if (isset($answer->error))
			return (object) array('error' => true, 'error_description' => $answer->error_description);

		/* Отвязка аккаунта */
		if ($target_token) {
			$context = stream_context_create(array(
				'http' => array('method' => 'POST',
					'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
					'content' => "access_token=$answer->access_token&target_token=$target_token&application_id=$client_id"
					)));
			$answer = json_decode(@file_get_contents("https://loginbycall.com/api/oauth/v2/userinfo/destroy", false, $context));

			/* Обрабатываем ошибку отвязки пользователя */
			if (isset($answer->error))
				return (object) array('error' => true, 'error_description' => $answer->error_description);
			if ($answer->status == 'success')
				return (object) array('error' => false, 'destroy' => true);
		}
		else {
			/* GET запрос на получение пользовательских данных */
			$answer = json_decode(@file_get_contents('https://loginbycall.com/api/oauth/v2/userinfo/get?access_token=' . $answer->access_token));
			/* Обрабатываем ошибку получения пользовательских данных */
			if (isset($answer->error))
				return (object) array('error' => true, 'error_description' => $answer->error_description);

			/* Возвращаем успешный результат */
			if ($answer) {
				return (object) array('error' => false, 'login' => $answer->login, 'email' => $answer->email, 'target_token' => $answer->target_token, 'destroy' => false);
			} else {
				return false;
			}
		}
		return (object) array('error' => true, 'error_description' => 'unknown error');
	}

	/* Функция получения значения единственного поля */

	public function get_one_field($select, $from, $where, $value) {
		$i_user = $this->db->query("SELECT " . $select . " FROM " . DB_PREFIX . $from . " WHERE " . $where . " = " . $value);
		if (count($i_user)) {
			return $i_user[0][$select];
		} else {
			return false;
		}
	}

	/* функция генерации пароля */

	public function password_generator($max) {
		$password = null;
		$chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
		$size = StrLen($chars) - 1;
		while ($max--)
			$password.=$chars[rand(0, $size)];
		return $password;
	}

	/* Функция получения ссылки на сервис */

	public function loginbycall_create_link($loginbycall_client_id, $loginbycall_redirect_uri, $new_account = NULL) {
		($new_account) ? $new = '&new_account=' . $new_account : $new = NULL;
		return 'https://loginbycall.com/oauth/authorize?client_id=' . $loginbycall_client_id . '&redirect_uri=' . $loginbycall_redirect_uri . '&response_type=code' . $new; //&new_account='.$new_account);
	}

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
