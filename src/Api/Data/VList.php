<?php
namespace Liaiyong\Subscriber\Api\Data;

use Lay\Advance\Core\Component;
use Lay\Advance\Util\Logger;

use Liaiyong\Subscriber\Api\Data\VBasic;

class VList extends VBasic {
    protected $total = 0;
    protected $hasNext = false;
    protected $since = '';
    protected $list = array();
	public function rules() {
		return array(
			'list' => Component::TYPE_PURE_ARRAY,
			'total' => Component::TYPE_INTEGER,
			'hasNext' => Component::TYPE_BOOLEAN,
			'since' => Component::TYPE_STRING
		);
	}
}
// PHP END