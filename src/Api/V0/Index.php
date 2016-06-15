<?php
namespace Liaiyong\Subscriber\Api\V0;

use Lay\Advance\Util\Logger;
use Lay\Advance\Core\Errode;
use Lay\Advance\Core\Error;

use Liaiyong\Subscriber\Api\Data\VList;
use Liaiyong\Subscriber\Api\AbsApi;

use Respect\Validation\Validator;
use Exception;

class Index extends AbsApi {
	public function onGet() {
		$this->success(1);
	}
	public function onPost() {
		$this->onGet();
	}

	protected function params() {
		return array(
		);
	}
}
// PHP END