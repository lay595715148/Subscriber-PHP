<?php
namespace Liaiyong\Subscriber\Api\Error;

use Lay\Advance\Core\Errode;
use Lay\Advance\Util\Logger;

use Liaiyong\Subscriber\Api\AbsApi;

class Trustee extends AbsApi {
	public function onGet() {
		$this->failure(Errode::__lastErrode());
	}
	public function onPost() {
		$this->onGet();
	}
}
// PHP END