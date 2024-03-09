<?php
require_once 'user.class.php';
require_once 'auth.class.php';
require_once 'response.php';

$auth = new Authentication();

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST':
		$user = json_decode(file_get_contents('php://input'), true);

		$token = $auth->signIn($user);

		$response = array(
			'result' => 'ok',
			'token' => $token
		);

		Response::result(201, $response);

		break;
}