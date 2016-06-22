<?php
use Liaiyong\Tao\Yaf\Controller;

class ErrorController extends Controller {
	public function errorAction() {
		$e = $this->_request->getException();
		var_dump($e);exit;
	}
}