<?php
namespace Liaiyong\Subscriber\Api\Data;

use Lay\Advance\Core\Component;
use Lay\Advance\Core\Errode;

use Liaiyong\Subscriber\Api\Data\VBasic;

class VResponse extends VBasic {
    protected $rsp = 1;
    protected $api = '';
    protected $code = 0;
    protected $data = '';
	public function rules() {
		return array(
			'rsp' => array(Component::TYPE_ENUM, array(0, 1)),
			'api' => Component::TYPE_STRING,
			'code' => array(Component::TYPE_FORMAT, array('type' => 'code')),
			'data' => array(Component::TYPE_FORMAT, array('type' => 'data'))
		);
	}
	public function format($val, $key, $option = array()) {
		$ret = '';
		switch ($key) {
			case 'code':
				if(is_numeric($val)) {
					$ret = intval($val);
				} else if( $val instanceof Errode){
					$this->rsp = 0;
					$ret = $val->code;
					$this->data = $val->message;
				}
				break;
			case 'data':
				if(is_scalar($val) && !is_null($val)) {
					$ret = $val;
				} else if(is_array($val)){
					$ret = $val;
				} else if($val instanceof VBasic){
					$ret = $val;
				} else if( $val instanceof Errode){
					$this->rsp = 0;
					$this->code = $val->code;
					$ret = $val->message;
				}
				break;
			default:
				break;
		}
		return $ret;
	}
}
// PHP END